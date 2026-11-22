<?php
namespace App\Auth;

use App\Models\User;
use App\Services\AuthService;
use Core\Http\Request;
use Core\Http\Session;

/**
 * Guard de autenticação: resolve o usuário logado via sessão (web) ou Bearer token (API).
 */
class Auth {
    public static function user(?Request $request = null): ?User {
        $request ??= Request::capture();

        $id = Session::get('user_id');
        if ($id !== null) {
            $user = User::find((int) $id);
            if ($user !== null) {
                return $user;
            }
        }

        $token = $request->bearerToken();
        if ($token !== null && $token !== '') {
            return (new AuthService())->userFromToken($token);
        }

        return null;
    }

    public static function check(?Request $request = null): bool {
        return self::user($request) !== null;
    }

    public static function hasRole(string|array $roles, ?Request $request = null): bool {
        $user = self::user($request);
        return $user !== null && $user->hasRole($roles);
    }
}
