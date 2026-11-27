<?php
namespace Core;

use Core\Http\Request;
use Core\Http\Response;
use Core\Http\Session;
use Core\Logging\Logger;
use Core\Routing\Router;
use Core\Support\Env;
use Core\View\View;
use Throwable;

class Application {
    private string $basePath;

    public function run() {
        $this->basePath = dirname(__DIR__);

        Env::load($this->basePath . '/.env');
        date_default_timezone_set((string) Env::get('APP_TIMEZONE', 'America/Bahia'));

        View::setBasePath($this->basePath . '/app/Views');
        View::addGlobal('app_name', (string) Env::get('APP_NAME', 'BugLivre'));
        View::addGlobal('year', date('Y'));
        View::addGlobal('manga_statuses', \App\Models\Manga::statuses());
        View::addGlobal('role_labels', \App\Auth\Role::options());

        $this->registerErrorHandling();

        $request = Request::capture();
        View::addGlobal('current_path', $request->path());

        // Sessão compartilhada: a área web e a API usam o mesmo cookie de sessão.
        // A API aceita tanto a sessão web quanto o token Bearer (ver App\Auth\Auth).
        Session::start();
        if (!$request->isApi()) {
            View::addGlobal('auth', $this->currentAuth());
        }

        Logger::instance()->info('Requisição recebida', [
            'method' => $request->method(),
            'path' => $request->path(),
            'ip' => $request->ip(),
        ]);

        // Modo de manutenção: bloqueia tudo, exceto o staff autenticado (perfil moderador+).
        if ($this->inMaintenance() && !$this->maintenanceBypass()) {
            $this->respondMaintenance($request);
            return;
        }

        $router = new Router();
        require $this->basePath . '/routes/web.php';

        $router->group('/api', function ($router) {
            require $this->basePath . '/routes/api.php';
        }, ['throttle:120,1']);

        $router->start();
    }

    /**
     * Dados de sessão usados pelos templates (global "auth").
     *
     * @return array{check: bool, name: string, role: string, can_manage: bool}
     */
    private function currentAuth(): array {
        $role = (string) Session::get('user_role', \App\Auth\Role::USER);

        return [
            'check' => Session::has('user_id'),
            'name' => (string) Session::get('user_name', ''),
            'role' => $role,
            'can_manage' => \App\Auth\Role::atLeast($role, \App\Auth\Role::MODERATOR),
        ];
    }

    /**
     * Indica se o site está em manutenção (APP_MAINTENANCE=true no .env).
     */
    private function inMaintenance(): bool {
        return config_bool('APP_MAINTENANCE', false);
    }

    /**
     * Staff autenticado (perfil moderador ou superior) ignora a manutenção
     * para poder testar o site durante a janela de manutenção.
     */
    private function maintenanceBypass(): bool {
        $role = (string) Session::get('user_role', \App\Auth\Role::USER);

        return Session::has('user_id') && \App\Auth\Role::atLeast($role, \App\Auth\Role::MODERATOR);
    }

    /**
     * Responde a manutenção: 503 JSON na API e a página dedicada na web.
     */
    private function respondMaintenance(Request $request): void {
        $message = (string) Env::get('APP_MAINTENANCE_MESSAGE', 'O site está temporariamente indisponível para manutenção. Voltamos em breve.');
        $headers = ['Retry-After' => '3600'];

        if ($request->wantsJson()) {
            Response::json(['status' => 503, 'message' => $message], 503, $headers)->send();
            return;
        }

        try {
            $html = View::render('maintenance', ['message' => $message]);
            Response::html($html, 503, $headers)->send();
        } catch (Throwable) {
            Response::html('503 Em manutenção', 503, $headers)->send();
        }
    }

    private function registerErrorHandling(): void {
        error_reporting(E_ALL);
        ini_set('display_errors', config_bool('APP_DEBUG', false) ? '1' : '0');

        set_error_handler(function (int $severity, string $message, string $file, int $line) {
            if (!(error_reporting() & $severity)) {
                return false;
            }
            throw new \ErrorException($message, 0, $severity, $file, $line);
        });

        set_exception_handler(function (Throwable $e) {
            Logger::instance()->error($e->getMessage(), [
                'exception' => $e::class,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            $status = $e instanceof \Core\Exceptions\HttpException ? $e->getStatusCode() : 500;
            $debug = config_bool('APP_DEBUG', false);
            $message = ($status === 500 && !$debug) ? 'Erro interno do servidor.' : $e->getMessage();

            $request = Request::capture();
            if ($request->wantsJson()) {
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
            } catch (Throwable) {
                Response::html("$status $message", $status)->send();
            }
        });
    }
}
