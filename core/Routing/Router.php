<?php
namespace Core\Routing;

use Core\Http\Request;
use Core\Http\Response;
use Core\View\View;

class Router {
    protected string $prefix = '';

    /** Middleware acumulado pelo grupo atual (aplicado a todas as rotas internas). */
    private array $groupMiddleware = [];

    private const PARAMETER_PATTERNS = [
        'str'   => '[^/]+',                  // um segmento de texto
        'int'   => '-?\d+',                  // inteiro, com sinal opcional
        'float' => '-?\d+(?:\.\d+)?',        // decimal
        'bool'  => 'true|false|1|0',         // booleano
        'mixed' => '.+',                     // qualquer valor, inclusive com "/"
    ];
    private const DEFAULT_PARAMETER_TYPE = 'str';

    /**
     * Apelidos de middleware usados nas rotas.
     * Ex.: 'auth' ou 'role:admin,moderador'.
     */
    private const MIDDLEWARE_ALIASES = [
        'auth' => \App\Middleware\Authenticate::class,
        'role' => \App\Middleware\EnsureRole::class,
    ];

    private array $staticRoutes = [];   // rotas sem parâmetros, indexadas por [método][caminho]
    private array $dynamicRoutes = [];  // rotas com parâmetros, compiladas por regex, [método][caminho]

    public function get(string $path, callable|array $callback, array $middleware = []) {
        $this->match('GET', $path, $callback, $middleware);
    }
    public function post(string $path, callable|array $callback, array $middleware = []) {
        $this->match('POST', $path, $callback, $middleware);
    }
    public function put(string $path, callable|array $callback, array $middleware = []) {
        $this->match('PUT', $path, $callback, $middleware);
    }
    public function delete(string $path, callable|array $callback, array $middleware = []) {
        $this->match('DELETE', $path, $callback, $middleware);
    }
    public function patch(string $path, callable|array $callback, array $middleware = []) {
        $this->match('PATCH', $path, $callback, $middleware);
    }
    public function match(string $method, string $path, callable|array $callback, array $middleware = []) {
        $method = strtoupper($method);
        $fullPath = $this->normalize($this->prefix . $path);
        if(isset($this->staticRoutes[$method][$fullPath]) || isset($this->dynamicRoutes[$method][$fullPath])) {
            throw new \Exception('Route already exists');
        }
        if(is_array($callback)) {
            [$controller, $action] = $callback;
            if (!class_exists($controller)) {
                throw new \Exception("Controller $controller not found");
            }
            if (!method_exists($controller, $action)) {
                throw new \Exception("Action $action not found in controller $controller");
            }
        }
        else {
            // normaliza callables (closures/funções) para o formato interno
            $controller = $callback;
            $action = '__invoke';
        }
        $route = [
            'controller' => $controller,
            'action' => $action,
            'middleware' => array_merge($this->groupMiddleware, $middleware),
        ];
        if(strpos($fullPath, '{') === false) {
            $this->staticRoutes[$method][$fullPath] = $route;
        }
        else {
            $compiled = $this->compile($fullPath);
            $route['regex'] = $compiled['regex'];
            $route['params'] = $compiled['params'];
            $this->dynamicRoutes[$method][$fullPath] = $route;
        }
    }
    public function group(string $prefix, callable $callback, array $middleware = []) {
        $oldPrefix = $this->prefix;
        $oldMiddleware = $this->groupMiddleware;
        $this->prefix = $this->normalize($this->prefix . '/' . $prefix);
        $this->groupMiddleware = array_merge($this->groupMiddleware, $middleware);
        $callback($this);
        $this->prefix = $oldPrefix;
        $this->groupMiddleware = $oldMiddleware;
    }
    public function start() {
        $request = Request::capture();
        $method = strtoupper($request->method());
        $uri = $this->normalize($request->path());

        $route = $this->staticRoutes[$method][$uri] ?? null;
        $params = [];

        if($route === null && !empty($this->dynamicRoutes[$method])) {
            foreach($this->dynamicRoutes[$method] as $dynamic) {
                if(preg_match($dynamic['regex'], $uri, $matches)) {
                    $route = $dynamic;
                    foreach($dynamic['params'] as $name => $type) {
                        $params[] = $this->castParameter($matches[$name], $type);
                    }
                    break;
                }
            }
        }

        if($route === null) {
            $this->abort(404, 'Not Found');
            return;
        }

        $this->dispatch($route, $params, $request);
    }

    private function dispatch(array $route, array $params, Request $request) {
        $core = fn() => $this->invoke($route, $params);

        // Encadeia os middlewares em volta do controller (o último da lista é o mais interno).
        $pipeline = array_reduce(
            array_reverse($route['middleware'] ?? []),
            fn(callable $next, mixed $definition) => fn() => $this->resolveMiddleware($definition)->handle($request, $next),
            $core
        );

        $this->sendResult($pipeline());
    }

    /**
     * Instancia um middleware a partir de um objeto, nome de classe ou apelido ('role:admin,moderador').
     */
    private function resolveMiddleware(mixed $definition): MiddlewareInterface {
        if($definition instanceof MiddlewareInterface) {
            return $definition;
        }

        if(!is_string($definition) || $definition === '') {
            throw new \Exception('Definição de middleware inválida.');
        }

        $name = $definition;
        $args = [];

        if(str_contains($definition, ':')) {
            [$name, $argString] = explode(':', $definition, 2);
            $args = array_values(array_filter(
                array_map('trim', explode(',', $argString)),
                static fn(string $arg): bool => $arg !== ''
            ));
        }

        $class = self::MIDDLEWARE_ALIASES[$name] ?? $name;

        if(!class_exists($class)) {
            throw new \Exception("Middleware [$class] não encontrado.");
        }

        return new $class(...$args);
    }

    private function invoke(array $route, array $params) {
        $controller = $route['controller'];
        $action = $route['action'];

        if(is_object($controller) || (is_string($controller) && !class_exists($controller))) {
            // callable direto (Closure ou nome de função)
            return $controller(...$params);
        }

        $instance = new $controller();
        return $instance->$action(...$params);
    }

    private function sendResult(mixed $result): void {
        if($result instanceof Response) {
            $result->send();
            return;
        }

        if(is_array($result) || is_object($result)) {
            Response::json($result)->send();
            return;
        }

        if(is_string($result)) {
            echo $result;
        }
    }

    private function compile(string $path): array {
        $params = [];
        $regex = '';
        $offset = 0;

        if(preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)(?::([a-z]+))?\}/', $path, $matches, PREG_OFFSET_CAPTURE)) {
            foreach($matches[0] as $index => $match) {
                [$token, $position] = $match;
                $regex .= preg_quote(substr($path, $offset, $position - $offset), '#');
                $name = $matches[1][$index][0];
                $type = ($matches[2][$index][0] ?? '') !== '' ? $matches[2][$index][0] : self::DEFAULT_PARAMETER_TYPE;
                $params[$name] = $type;
                $pattern = self::PARAMETER_PATTERNS[$type] ?? self::PARAMETER_PATTERNS[self::DEFAULT_PARAMETER_TYPE];
                $regex .= '(?P<' . $name . '>' . $pattern . ')';
                $offset = $position + strlen($token);
            }
        }

        $regex .= preg_quote(substr($path, $offset), '#');

        return ['regex' => '#^' . $regex . '$#', 'params' => $params];
    }

    private function castParameter(string $value, string $type) {
        return match($type) {
            'int'   => (int) $value,
            'float' => (float) $value,
            'bool'  => $value === 'true' || $value === '1',
            default => $value,
        };
    }

    private function normalize(string $path): string {
        $path = '/' . trim($path, '/');
        $path = (string) preg_replace('#/+#', '/', $path);
        return $path === '/' ? '/' : rtrim($path, '/');
    }

    /**
     * Responde um erro respeitando o contexto: JSON na API, HTML na web.
     */
    private function abort(int $status, string $message): void {
        $request = Request::capture();

        if($request->wantsJson()) {
            Response::json(['status' => $status, 'message' => $message], $status)->send();
            return;
        }

        try {
            $html = View::render('errors/error', [
                'status' => $status,
                'message' => $message,
                'title' => (string) $status,
            ], 'app');
            Response::html($html, $status)->send();
        } catch(\Throwable) {
            Response::html("$status $message", $status)->send();
        }
    }
}
