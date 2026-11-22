<?php
namespace Core\Http;

class Response {
    public function __construct(
        private string $content = '',
        private int $status = 200,
        private array $headers = []
    ) {
    }

    public static function json(mixed $data, int $status = 200, array $headers = []): self {
        $payload = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        return new self(
            $payload === false ? '{}' : $payload,
            $status,
            array_merge(['Content-Type' => 'application/json; charset=utf-8'], $headers)
        );
    }

    public static function html(string $html, int $status = 200, array $headers = []): self {
        return new self(
            $html,
            $status,
            array_merge(['Content-Type' => 'text/html; charset=utf-8'], $headers)
        );
    }

    public static function redirect(string $location, int $status = 302): self {
        return new self('', $status, ['Location' => $location]);
    }

    public static function noContent(int $status = 204): self {
        return new self('', $status);
    }

    public function withHeader(string $name, string $value): self {
        $this->headers[$name] = $value;
        return $this;
    }

    public function status(): int {
        return $this->status;
    }

    public function content(): string {
        return $this->content;
    }

    public function headers(): array {
        return $this->headers;
    }

    public function send(): void {
        if (!headers_sent()) {
            http_response_code($this->status);
            foreach ($this->headers as $name => $value) {
                header("$name: $value");
            }
        }
        echo $this->content;
    }
}
