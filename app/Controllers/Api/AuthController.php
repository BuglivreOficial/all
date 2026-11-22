<?php
namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Services\AuthService;
use Core\Exceptions\ValidationException;
use Core\Http\Response;

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

        $this->logger()->info('Login via API', ['user_id' => $result['user']->id]);

        return $this->ok([
            'user' => $result['user']->toArray(),
            'token' => $result['token']['token'],
            'expires_at' => $result['token']['expires_at'],
        ], 'Login realizado com sucesso.');
    }

    public function me(): Response {
        $user = $this->auth->userFromToken($this->request->bearerToken());

        if ($user === null) {
            return $this->error('Não autenticado.', 401);
        }

        return $this->ok($user->toArray());
    }

    public function logout(): Response {
        $this->auth->logout($this->request->bearerToken());
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
}
