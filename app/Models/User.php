<?php
namespace App\Models;

use App\Auth\Role;
use Core\Database\Connection;

class User {
    public int $id = 0;
    public string $name = '';
    public string $username = '';
    public string $email = '';
    public string $password = '';
    public string $role = Role::USER;
    public ?string $created_at = null;

    public static function fromRow(array $row): self {
        $user = new self();
        $user->id = (int) $row['id'];
        $user->name = (string) $row['name'];
        $user->username = (string) ($row['username'] ?? '');
        $user->email = (string) $row['email'];
        $user->password = (string) $row['password'];
        $user->role = (string) ($row['role'] ?? Role::USER);
        $user->created_at = $row['created_at'] ?? null;
        return $user;
    }

    public static function find(int $id): ?self {
        $stmt = Connection::pdo()->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function findByEmail(string $email): ?self {
        $stmt = Connection::pdo()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    /**
     * Lista os usuários mais recentes.
     *
     * @return self[]
     */
    public static function latest(int $limit = 50): array {
        $stmt = Connection::pdo()->prepare('SELECT * FROM users ORDER BY id DESC LIMIT ?');
        $stmt->bindValue(1, $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return array_map(static fn(array $row): self => self::fromRow($row), $stmt->fetchAll());
    }

    public static function findByUsername(string $username): ?self {
        $stmt = Connection::pdo()->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
        $stmt->execute([$username]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    /**
     * Busca por e-mail ou nome de usuário (login alternativo).
     */
    public static function findByLogin(string $login): ?self {
        $stmt = Connection::pdo()->prepare('SELECT * FROM users WHERE email = ? OR username = ? LIMIT 1');
        $stmt->execute([$login, $login]);
        $row = $stmt->fetch();
        return $row ? self::fromRow($row) : null;
    }

    public static function create(
        string $name,
        string $username,
        string $email,
        string $plainPassword,
        string $role = Role::USER
    ): self {
        $pdo = Connection::pdo();
        $stmt = $pdo->prepare('INSERT INTO users (name, username, email, password, role) VALUES (?, ?, ?, ?, ?)');
        $stmt->execute([$name, $username, $email, password_hash($plainPassword, PASSWORD_DEFAULT), $role]);

        return self::find((int) $pdo->lastInsertId());
    }

    /**
     * Indica se o usuário possui um dos perfis informados, respeitando a hierarquia.
     * Ex.: um admin (nível 5) satisfaz 'moderador' (nível 3).
     *
     * @param string|string[] $roles
     */
    public function hasRole(string|array $roles): bool {
        $roles = is_array($roles) ? $roles : [$roles];

        $minimum = null;
        foreach ($roles as $role) {
            $level = Role::level((string) $role);
            if ($level > 0 && ($minimum === null || $level < $minimum)) {
                $minimum = $level;
            }
        }

        if ($minimum === null) {
            return false;
        }

        return Role::level($this->role) >= $minimum;
    }

    /**
     * Representação segura (sem a senha) para respostas.
     */
    public function toArray(): array {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
            'role_label' => Role::label($this->role),
            'created_at' => $this->created_at,
        ];
    }
}
