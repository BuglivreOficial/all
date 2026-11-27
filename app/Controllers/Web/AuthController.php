<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use Core\Http\Response;
use Core\Http\Session;

/**
 * Páginas de autenticação (shells). Os formulários enviam para /api/auth via JS,
 * que estabelece a sessão web compartilhada.
 */
class AuthController extends BaseController {
    public function showLogin(): Response {
        if (Session::has('user_id')) {
            return $this->redirect('/dashboard');
        }

        return $this->view('auth/login', [
            'title' => 'Entrar',
            'page' => 'login',
        ], 'app');
    }

    public function showRegister(): Response {
        if (Session::has('user_id')) {
            return $this->redirect('/dashboard');
        }

        return $this->view('auth/register', [
            'title' => 'Criar conta',
            'page' => 'register',
        ], 'app');
    }

    public function showForgot(): Response {
        if (Session::has('user_id')) {
            return $this->redirect('/dashboard');
        }

        return $this->view('auth/forgot', [
            'title' => 'Recuperar senha',
            'page' => 'forgot',
        ], 'app');
    }

    public function showReset(string $token): Response {
        return $this->view('auth/reset', [
            'title' => 'Redefinir senha',
            'page' => 'reset',
            'token' => $token,
        ], 'app');
    }

    public function dashboard(): Response {
        return $this->view('dashboard', [
            'title' => 'Painel',
            'page' => 'dashboard',
        ], 'app');
    }
}
