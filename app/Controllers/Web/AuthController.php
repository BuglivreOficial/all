<?php
namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Models\User;
use App\Services\AuthService;
use Core\Exceptions\ValidationException;
use Core\Http\Response;
use Core\Http\Session;

class AuthController extends BaseController {
    private AuthService $auth;

    public function __construct() {
        parent::__construct();
        $this->auth = new AuthService();
    }

    public function showLogin(): Response {
        if ($this->currentUserId() !== null) {
            return $this->redirect('/dashboard');
        }

        $old = Session::getFlash('old', []);

        return $this->view('auth/login', [
            'title' => 'Entrar',
            'error' => Session::getFlash('error'),
            'identifier' => (string) ($old['login'] ?? $old['email'] ?? ''),
        ], 'app');
    }

    public function login(): Response {
        $login = (string) ($this->request->input('login') ?? $this->request->input('email', ''));
        $password = (string) $this->request->input('password', '');

        $result = $this->auth->attempt($login, $password);

        if ($result === null) {
            $this->logger()->warning('Credenciais inválidas no login web', [
                'login' => $login,
                'ip' => $this->request->ip(),
            ]);
            Session::flash('error', 'Credenciais inválidas.');
            Session::flash('old', ['login' => $login]);
            return $this->redirect('/login');
        }

        $this->startSession($result['user']);
        $this->logger()->info('Login web', ['user_id' => $result['user']->id]);

        return $this->redirect('/dashboard');
    }

    public function showRegister(): Response {
        if ($this->currentUserId() !== null) {
            return $this->redirect('/dashboard');
        }

        return $this->view('auth/register', [
            'title' => 'Criar conta',
            'errors' => Session::getFlash('errors', []),
            'old' => Session::getFlash('old', []),
        ], 'app');
    }

    public function register(): Response {
        try {
            $result = $this->auth->register($this->request->all());
        } catch (ValidationException $e) {
            Session::flash('errors', $e->errors());
            Session::flash('old', $this->request->all());
            return $this->redirect('/register');
        }

        $this->startSession($result['user']);
        $this->logger()->info('Registro web', ['user_id' => $result['user']->id]);

        return $this->redirect('/dashboard');
    }

    public function logout(): Response {
        Session::destroy();
        return $this->redirect('/login');
    }

    public function dashboard(): Response {
        $user = $this->currentUser();

        if ($user === null) {
            Session::flash('error', 'Faça login para continuar.');
            return $this->redirect('/login');
        }

        return $this->view('dashboard', ['title' => 'Painel', 'user' => $user], 'app');
    }

    private function startSession(User $user): void {
        Session::regenerate();
        Session::set('user_id', $user->id);
        Session::set('user_name', $user->name);
        Session::set('user_role', $user->role);
    }

    private function currentUserId(): ?int {
        $id = Session::get('user_id');
        return $id === null ? null : (int) $id;
    }

    private function currentUser(): ?User {
        $id = $this->currentUserId();
        return $id === null ? null : User::find($id);
    }
}
