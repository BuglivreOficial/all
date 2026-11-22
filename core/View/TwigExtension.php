<?php
namespace Core\View;

use Core\Support\Env;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Funções e filtros disponíveis nos templates Twig.
 *
 * - url('/mangas')        URL relativa respeitando APP_URL (ex.: '/mangas' ou 'https://site/mangas').
 * - asset('css/site.css') URL de um arquivo em public/assets, com cache-busting por data de modificação.
 * - env('APP_NAME', ...)  Lê uma variável de ambiente.
 * - excerpt(texto, 120)   Filtro que encurta um texto e adiciona "…".
 */
class TwigExtension extends AbstractExtension {
    public function getFunctions(): array {
        return [
            new TwigFunction('url', [$this, 'url']),
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('env', [$this, 'env']),
        ];
    }

    public function getFilters(): array {
        return [
            new TwigFilter('excerpt', [$this, 'excerpt']),
        ];
    }

    public function url(string $path = '/'): string {
        $base = rtrim((string) Env::get('APP_URL', ''), '/');
        return $base . '/' . ltrim($path, '/');
    }

    public function asset(string $path): string {
        $relative = ltrim($path, '/');
        $file = base_path('public/assets/' . $relative);
        $version = is_file($file) ? '?v=' . filemtime($file) : '';
        return $this->url('/assets/' . $relative) . $version;
    }

    public function env(string $key, mixed $default = null): mixed {
        return Env::get($key, $default);
    }

    public function excerpt(?string $value, int $length = 120): string {
        $value = trim((string) $value);
        if ($value === '') {
            return '';
        }
        return mb_strlen($value) <= $length ? $value : mb_strimwidth($value, 0, $length, '…');
    }
}
