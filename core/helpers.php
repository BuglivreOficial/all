<?php
/**
 * Helpers globais do framework.
 * Carregado pelo bootstrap em core/Application.php.
 */

use Core\Logging\Logger;
use Core\Support\Env;

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string {
        $base = dirname(__DIR__);
        return $path === '' ? $base : $base . '/' . ltrim($path, '/');
    }
}

if (!function_exists('app_path')) {
    function app_path(string $path = ''): string {
        return base_path('app' . ($path === '' ? '' : '/' . ltrim($path, '/')));
    }
}

if (!function_exists('storage_path')) {
    function storage_path(string $path = ''): string {
        return base_path('storage' . ($path === '' ? '' : '/' . ltrim($path, '/')));
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null): mixed {
        return Env::get($key, $default);
    }
}

if (!function_exists('config_bool')) {
    function config_bool(string $key, bool $default = false): bool {
        $value = Env::get($key);
        if ($value === null) {
            return $default;
        }
        return in_array(strtolower((string) $value), ['1', 'true', 'yes', 'on'], true);
    }
}

if (!function_exists('logger')) {
    function logger(): Logger {
        return Logger::instance();
    }
}
