<?php
namespace App\Middleware;

use App\Auth\Auth;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\MiddlewareInterface;
use Core\View\View;

/**
 * Garante que o usuário autenticado tenha um dos perfis informados.
 * Uso nas rotas: 'role:admin' ou 'role:admin,moderador'.
 */
class EnsureRole implements MiddlewareInterface {
    private array $roles;

    public function __construct(string ...$roles) {
        $this->roles = $roles;
    }

    public function handle(Request $request, callable $next): mixed {
        $user = Auth::user($request);

        if ($user === null) {
            return $request->wantsJson()
                ? Response::json(['status' => 401, 'message' => 'Não autenticado.'], 401)
                : Response::redirect('/login');
        }

        if (!$user->hasRole($this->roles)) {
            if ($request->wantsJson()) {
                return Response::json(['status' => 403, 'message' => 'Acesso negado.'], 403);
            }

            try {
                $html = View::render('errors/error', [
                    'status' => 403,
                    'message' => 'Acesso negado.',
                    'title' => '403',
                ], 'app');
                return Response::html($html, 403);
            } catch (\Throwable) {
                return Response::html('403 Acesso negado.', 403);
            }
        }

        return $next();
    }
}
