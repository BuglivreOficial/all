<?php
namespace Core\Http;

class Session {
    public static function start(): void {
        if (session_status() === PHP_SESSION_NONE) {
            if (PHP_SAPI !== 'cli') {
                // SameSite=Lax reduz o risco de CSRF nas mutações feitas por cookie.
                session_set_cookie_params([
                    'lifetime' => 0,
                    'path' => '/',
                    'httponly' => true,
                    'samesite' => 'Lax',
                ]);
            }
            session_start();
        }
    }

    public static function get(string $key, mixed $default = null): mixed {
        return $_SESSION[$key] ?? $default;
    }

    public static function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public static function has(string $key): bool {
        return isset($_SESSION[$key]);
    }

    public static function forget(string $key): void {
        unset($_SESSION[$key]);
    }

    /**
     * Grava um valor que dura apenas até a próxima leitura.
     */
    public static function flash(string $key, mixed $value): void {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function getFlash(string $key, mixed $default = null): mixed {
        if (!isset($_SESSION['_flash'][$key])) {
            return $default;
        }
        $value = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $value;
    }

    public static function regenerate(): void {
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_regenerate_id(true);
        }
    }

    public static function destroy(): void {
        $_SESSION = [];
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }
    }
}
