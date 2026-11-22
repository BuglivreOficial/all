<?php
namespace App\Services;

use App\Auth\Role;
use App\Models\AuthToken;
use App\Models\User;
use Core\Exceptions\ValidationException;
use Core\Support\Env;

class AuthService {
    /**
     * Valida os dados, cria o usuário e já emite um token de API.
     *
     * @return array{user: User, token: array{token: string, expires_at: string}}
     * @throws ValidationException
     */
    public function register(array $data): array {
        $name = trim((string) ($data['name'] ?? ''));
        $username = trim((string) ($data['username'] ?? ''));
        $email = strtolower(trim((string) ($data['email'] ?? '')));
        $password = (string) ($data['password'] ?? '');
        $confirmation = (string) ($data['password_confirmation'] ?? '');

        $errors = [];

        if ($name === '') {
            $errors['name'][] = 'O nome é obrigatório.';
        } elseif (mb_strlen($name) < 3) {
            $errors['name'][] = 'O nome deve ter ao menos 3 caracteres.';
        }

        if ($username === '') {
            $errors['username'][] = 'O nome de usuário é obrigatório.';
        } elseif (!preg_match('/^[a-zA-Z0-9_.-]{3,60}$/', $username)) {
            $errors['username'][] = 'Use de 3 a 60 caracteres: letras, números, ponto, hífen ou underline.';
        } elseif (User::findByUsername($username) !== null) {
            $errors['username'][] = 'Este nome de usuário já está em uso.';
        }

        if ($email === '') {
            $errors['email'][] = 'O e-mail é obrigatório.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'Informe um e-mail válido.';
        } elseif (User::findByEmail($email) !== null) {
            $errors['email'][] = 'Este e-mail já está cadastrado.';
        }

        if ($password === '') {
            $errors['password'][] = 'A senha é obrigatória.';
        } elseif (strlen($password) < 8) {
            $errors['password'][] = 'A senha deve ter no mínimo 8 caracteres.';
        } elseif ($confirmation !== '' && $password !== $confirmation) {
            $errors['password'][] = 'A confirmação de senha não confere.';
        }

        if ($errors !== []) {
            throw new ValidationException($errors);
        }

        $user = User::create($name, $username, $email, $password, Role::USER);
        $token = AuthToken::issue($user->id, $this->ttl());

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Autentica por e-mail OU nome de usuário.
     *
     * @return array{user: User, token: array{token: string, expires_at: string}}|null
     */
    public function attempt(string $login, string $password): ?array {
        $login = trim($login);
        if ($login === '') {
            return null;
        }

        // E-mails são normalizados em minúsculo; nomes de usuário são comparados como informados.
        $identifier = str_contains($login, '@') ? strtolower($login) : $login;

        $user = User::findByLogin($identifier);

        if ($user === null || !password_verify($password, $user->password)) {
            return null;
        }

        return ['user' => $user, 'token' => AuthToken::issue($user->id, $this->ttl())];
    }

    public function userFromToken(?string $rawToken): ?User {
        if ($rawToken === null || $rawToken === '') {
            return null;
        }

        $row = AuthToken::findValid($rawToken);
        if ($row === null) {
            return null;
        }

        AuthToken::touch($rawToken);

        return User::find((int) $row['user_id']);
    }

    public function logout(?string $rawToken): void {
        if ($rawToken !== null && $rawToken !== '') {
            AuthToken::revoke($rawToken);
        }
    }

    /**
     * @return array{user: User, token: array{token: string, expires_at: string}}|null
     */
    public function refresh(?string $rawToken): ?array {
        $user = $this->userFromToken($rawToken);
        if ($user === null) {
            return null;
        }

        AuthToken::revoke((string) $rawToken);
        $token = AuthToken::issue($user->id, $this->ttl());

        return ['user' => $user, 'token' => $token];
    }

    private function ttl(): int {
        return (int) Env::get('AUTH_TOKEN_TTL', 2592000);
    }
}
