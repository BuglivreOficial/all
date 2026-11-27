<?php
namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;
use Core\RateLimit\RateLimiter;
use Core\Routing\MiddlewareInterface;
use Core\View\View;

/**
 * Limita a taxa de requisições por identificador (usuário autenticado ou IP) e rota.
 *
 * Uso nas rotas:
 *   'throttle'       -> padrão: 60 requisições por minuto
 *   'throttle:10,1'  -> 10 requisições por minuto
 *   'throttle:100,5' -> 100 requisições a cada 5 minutos
 *
 * Formato: 'throttle:maxAttempts,decayMinutes'.
 */
class ThrottleRequests implements MiddlewareInterface {
    private int $maxAttempts;
    private int $decaySeconds;

    public function __construct(int|string $maxAttempts = 60, int|string $decayMinutes = 1) {
        $this->maxAttempts = max(1, (int) $maxAttempts);
        $this->decaySeconds = max(1, (int) $decayMinutes) * 60;
    }

    public function handle(Request $request, callable $next): mixed {
        $state = (new RateLimiter())->hit($this->key($request), $this->maxAttempts, $this->decaySeconds);

        if (!$state['allowed']) {
            logger()->warning('Requisição limitada (429)', [
                'method' => $request->method(),
                'path' => $request->path(),
                'ip' => $request->ip(),
                'limit' => $state['limit'],
            ]);

            return $this->tooManyRequests($request, $state);
        }

        $result = $next();

        // Não sobrescreve o cabeçalho caso um throttle mais interno já o tenha definido.
        if ($result instanceof Response && !isset($result->headers()['X-RateLimit-Limit'])) {
            return $result
                ->withHeader('X-RateLimit-Limit', (string) $state['limit'])
                ->withHeader('X-RateLimit-Remaining', (string) $state['remaining']);
        }

        return $result;
    }

    private function key(Request $request): string {
        // O limite/janela entram na chave para que limitadores distintos (ex.: global
        // da API e específico do login) não compartilhem o mesmo contador.
        return implode('|', [
            $request->method(),
            $request->path(),
            $this->identity($request),
            $this->maxAttempts,
            $this->decaySeconds,
        ]);
    }

    /**
     * Identidade do cliente: usuário da sessão, token Bearer ou IP.
     * Evita consulta ao banco (usa a sessão/token diretamente).
     */
    private function identity(Request $request): string {
        $userId = Session::get('user_id');
        if ($userId !== null) {
            return 'user:' . (int) $userId;
        }

        $token = $request->bearerToken();
        if ($token !== null && $token !== '') {
            return 'token:' . hash('sha256', $token);
        }

        return 'ip:' . $request->ip();
    }

    /**
     * @param array{limit: int, remaining: int, retry_after: int} $state
     */
    private function tooManyRequests(Request $request, array $state): Response {
        $headers = [
            'Retry-After' => (string) $state['retry_after'],
            'X-RateLimit-Limit' => (string) $state['limit'],
            'X-RateLimit-Remaining' => '0',
        ];
        $message = 'Muitas requisições. Tente novamente em ' . $state['retry_after'] . 's.';

        if ($request->wantsJson()) {
            return Response::json(['status' => 429, 'message' => $message], 429, $headers);
        }

        try {
            $html = View::render('errors/error', [
                'status' => 429,
                'message' => $message,
                'title' => '429',
            ], 'app');
            return Response::html($html, 429, $headers);
        } catch (\Throwable) {
            return Response::html('429 ' . $message, 429, $headers);
        }
    }
}
