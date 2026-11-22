<?php
namespace App\Middleware;

use App\Auth\Auth;
use Core\Http\Request;
use Core\Http\Response;
use Core\Routing\MiddlewareInterface;

class Authenticate implements MiddlewareInterface {
    public function handle(Request $request, callable $next): mixed {
        if (Auth::user($request) === null) {
            return $request->wantsJson()
                ? Response::json(['status' => 401, 'message' => 'Não autenticado.'], 401)
                : Response::redirect('/login');
        }

        return $next();
    }
}
