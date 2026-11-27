<?php
namespace App\Models;

use Core\Database\Connection;

/**
 * Tokens de redefinição de senha.
 *
 * Como em AuthToken, apenas o hash SHA-256 é gravado; o token em texto puro
 * só é devolvido uma vez, para ser enviado por e-mail.
 */
class PasswordReset {
    /**
     * Gera um token opaco e o associa ao usuário, invalidando pedidos anteriores.
     *
     * @return array{token: string, expires_at: string}
     */
    public static function issue(int $userId, int $ttlSeconds): array {
        $rawToken = bin2hex(random_bytes(32));
        $hash = hash('sha256', $rawToken);
        $expiresAt = date('Y-m-d H:i:s', time() + $ttlSeconds);

        // Apenas um pedido válido por vez.
        self::deleteForUser($userId);

        $stmt = Connection::pdo()->prepare(
            'INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)'
        );
        $stmt->execute([$userId, $hash, $expiresAt]);

        return ['token' => $rawToken, 'expires_at' => $expiresAt];
    }

    public static function findValid(string $rawToken): ?array {
        $stmt = Connection::pdo()->prepare(
            'SELECT * FROM password_resets
             WHERE token = ? AND used_at IS NULL AND expires_at > NOW()
             LIMIT 1'
        );
        $stmt->execute([hash('sha256', $rawToken)]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public static function consume(string $rawToken): void {
        $stmt = Connection::pdo()->prepare(
            'UPDATE password_resets SET used_at = NOW() WHERE token = ? AND used_at IS NULL'
        );
        $stmt->execute([hash('sha256', $rawToken)]);
    }

    public static function deleteForUser(int $userId): void {
        $stmt = Connection::pdo()->prepare('DELETE FROM password_resets WHERE user_id = ?');
        $stmt->execute([$userId]);
    }
}
