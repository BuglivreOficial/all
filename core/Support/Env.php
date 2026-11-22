<?php
namespace Core\Support;

class Env {
    private static bool $loaded = false;

    /**
     * Carrega as variáveis de um arquivo .env (não sobrescreve variáveis já definidas).
     */
    public static function load(string $path): void {
        if (self::$loaded || !is_file($path)) {
            return;
        }

        foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
            $line = trim($line);
            if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) {
                continue;
            }

            [$key, $value] = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value);

            // remove aspas simples ou duplas
            $length = strlen($value);
            if ($length >= 2 && ($value[0] === '"' || $value[0] === "'") && $value[0] === $value[$length - 1]) {
                $value = substr($value, 1, -1);
            }

            if (getenv($key) === false) {
                putenv("$key=$value");
                $_ENV[$key] = $value;
            }
        }

        self::$loaded = true;
    }

    public static function get(string $key, mixed $default = null): mixed {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}
