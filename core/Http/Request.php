<?php
namespace Core\Http;

class Request {
    public function __construct(
        private string $method,
        private string $path,
        private array $query,
        private array $body,
        private array $headers,
        private array $files,
        private array $server
    ) {
    }

    /**
     * Cria a requisição a partir das variáveis globais do PHP.
     */
    public static function capture(): self {
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
        $path = (string) parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH);
        $headers = self::readHeaders($_SERVER);

        return new self(
            $method,
            $path,
            $_GET ?? [],
            self::readBody($method, $headers),
            $headers,
            $_FILES ?? [],
            $_SERVER ?? []
        );
    }

    public function method(): string {
        return $this->method;
    }

    public function path(): string {
        return $this->path;
    }

    public function query(?string $key = null, mixed $default = null): mixed {
        if ($key === null) {
            return $this->query;
        }
        return $this->query[$key] ?? $default;
    }

    public function input(string $key, mixed $default = null): mixed {
        return $this->body[$key] ?? $default;
    }

    public function all(): array {
        return array_merge($this->query, $this->body);
    }

    public function file(string $key): ?array {
        return $this->files[$key] ?? null;
    }

    public function header(string $name, ?string $default = null): ?string {
        $needle = strtolower($name);
        foreach ($this->headers as $key => $value) {
            if (strtolower($key) === $needle) {
                return $value;
            }
        }
        return $default;
    }

    public function bearerToken(): ?string {
        $authorization = (string) $this->header('Authorization', '');
        if (preg_match('/Bearer\s+(.+)/i', $authorization, $matches)) {
            return trim($matches[1]);
        }
        return null;
    }

    /**
     * Indica se a requisição é da API (prefixo /api) ou espera JSON.
     */
    public function isApi(): bool {
        return str_starts_with($this->path, '/api');
    }

    public function wantsJson(): bool {
        if ($this->isApi()) {
            return true;
        }
        $accept = (string) $this->header('Accept', '');
        return str_contains(strtolower($accept), 'application/json');
    }

    public function ip(): string {
        return (string) ($this->server['REMOTE_ADDR'] ?? '127.0.0.1');
    }

    private static function readHeaders(array $server): array {
        $headers = [];

        foreach ($server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $name = str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($key, 5)))));
                $headers[$name] = $value;
            }
        }

        if (isset($server['CONTENT_TYPE'])) {
            $headers['Content-Type'] = $server['CONTENT_TYPE'];
        }
        if (isset($server['CONTENT_LENGTH'])) {
            $headers['Content-Length'] = $server['CONTENT_LENGTH'];
        }

        return $headers;
    }

    private static function readBody(string $method, array $headers): array {
        $contentType = '';
        foreach ($headers as $key => $value) {
            if (strtolower($key) === 'content-type') {
                $contentType = strtolower((string) $value);
                break;
            }
        }

        if (str_contains($contentType, 'application/json')) {
            $raw = file_get_contents('php://input');
            $decoded = json_decode($raw ?: '', true);
            return is_array($decoded) ? $decoded : [];
        }

        return $_POST ?? [];
    }
}
