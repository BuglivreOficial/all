<?php
namespace App\Models;

use Core\Database\Connection;

class AuthToken {
    /**
     * Gera um token opaco, salva apenas o hash (sha256) no banco e devolve o token em texto puro.
     */
    public static function issue(int $userId, int $ttlSeconds): array {
        $rawToken = bin2hex(random_bytes(32));
        $hash = hash('sha256', $rawToken);
        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        $stmt = Connection::pdo()->prepare(
            'INSERT INTO auth_tokens (user_id, token, expires_at) VALUES (?, ?, ?)'
        );
        $stmt->execute([$userId, $hash, $expiresAt]);

        return ['token' => $rawToken, 'expires_at' => $expiresAt];
    }

    public static function findValid(string $rawToken): ?array {
        $stmt = Connection::pdo()->prepare(
            'SELECT * FROM auth_tokens
             WHERE token = ? AND revoked_at IS NULL AND expires_at > NOW()
             LIMIT 1'
        );
        $stmt->execute([hash('sha256', $rawToken)]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function touch(string $rawToken): void {
        $stmt = Connection::pdo()->prepare('UPDATE auth_tokens SET last_used_at = NOW() WHERE token = ?');
        $stmt->execute([hash('sha256', $rawToken)]);
    }

    public static function revoke(string $rawToken): void {
        $stmt = Connection::pdo()->prepare(
            'UPDATE auth_tokens SET revoked_at = NOW() WHERE token = ? AND revoked_at IS NULL'
        );
        $stmt->execute([hash('sha256', $rawToken)]);
    }

    public static function revokeAllForUser(int $userId): void {
        $stmt = Connection::pdo()->prepare(
            'UPDATE auth_tokens SET revoked_at = NOW() WHERE user_id = ? AND revoked_at IS NULL'
        );
        $stmt->execute([$userId]);
    }
}
