<?php
namespace App\Controllers\Api;

use App\Auth\Auth;
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

    public function register(): Response {
        try {
            $result = $this->auth->register($this->request->all());
        } catch (ValidationException $e) {
            $this->logger()->warning('Falha no registro via API', [
                'login' => $this->request->input('username') ?? $this->request->input('email'),
                'errors' => $e->errors(),
                'ip' => $this->request->ip(),
            ]);
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $this->startSession($result['user']);
        $this->logger()->info('Usuário registrado', ['user_id' => $result['user']->id]);

        return $this->created([
            'user' => $result['user']->toArray(),
            'token' => $result['token']['token'],
            'expires_at' => $result['token']['expires_at'],
        ], 'Usuário registrado com sucesso.');
    }

    public function login(): Response {
        // Aceita e-mail ou nome de usuário no mesmo campo "login".
        $login = (string) ($this->request->input('login') ?? $this->request->input('email', ''));
        $password = (string) $this->request->input('password', '');

        $result = $this->auth->attempt($login, $password);

        if ($result === null) {
            $this->logger()->warning('Credenciais inválidas na API', [
                'login' => $login,
                'ip' => $this->request->ip(),
            ]);
            return $this->error('Credenciais inválidas.', 401);
        }

        $this->startSession($result['user']);
        $this->logger()->info('Login via API', ['user_id' => $result['user']->id]);

        return $this->ok([
            'user' => $result['user']->toArray(),
            'token' => $result['token']['token'],
            'expires_at' => $result['token']['expires_at'],
        ], 'Login realizado com sucesso.');
    }

    public function forgotPassword(): Response {
        try {
            $this->auth->requestPasswordReset((string) $this->request->input('email', ''));
        } catch (ValidationException $e) {
            return $this->error('Dados inválidos.', 422, $e->errors());
        }

        $this->logger()->info('Pedido de redefinição de senha', [
            'email' => (string) $this->request->input('email', ''),
            'ip' => $this->request->ip(),
        ]);

        // Resposta genérica: não revela se o e-mail está cadastrado.
        return $this->ok(null, 'Se este e-mail estiver cadastrado, enviaremos um link para redefinir a senha.');
    }

    public function resetPassword(): Response {
        try {
            $user = $this->auth->resetPassword($this->request->all());
        } catch (ValidationException $e) {
            $this->logger()->warning('Falha ao redefinir senha', [
                'errors' => $e->errors(),
                'ip' => $this->request->ip(),
            ]);
            return $this->error('Não foi possível redefinir a senha.', 422, $e->errors());
        }

        $this->logger()->info('Senha redefinida', ['user_id' => $user->id]);

        return $this->ok(null, 'Senha redefinida com sucesso. Faça login com a nova senha.');
    }

    public function me(): Response {
        // Aceita a sessão web (cookie) ou o token Bearer.
        $user = Auth::user($this->request);

        if ($user === null) {
            return $this->error('Não autenticado.', 401);
        }

        return $this->ok($user->toArray());
    }

    public function logout(): Response {
        $this->auth->logout($this->request->bearerToken());
        Session::destroy();

        $this->logger()->info('Logout via API', ['ip' => $this->request->ip()]);

        return $this->ok(null, 'Sessão encerrada.');
    }

    public function refresh(): Response {
        $result = $this->auth->refresh($this->request->bearerToken());

        if ($result === null) {
            return $this->error('Não autenticado.', 401);
        }

        return $this->ok([
            'token' => $result['token']['token'],
            'expires_at' => $result['token']['expires_at'],
        ], 'Token renovado com sucesso.');
    }

    /**
     * Estabelece a sessão web (cookie) compartilhada com a API.
     */
    private function startSession(User $user): void {
        Session::regenerate();
        Session::set('user_id', $user->id);
        Session::set('user_name', $user->name);
        Session::set('user_role', $user->role);
    }
}
