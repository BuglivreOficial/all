<?php
namespace Core\Exceptions;

use RuntimeException;

class HttpException extends RuntimeException {
    public function __construct(
        protected int $statusCode,
        string $message = '',
        protected array $headers = []
    ) {
        parent::__construct($message !== '' ? $message : 'HTTP Error');
    }

    public function getStatusCode(): int {
        return $this->statusCode;
    }

    public function getHeaders(): array {
        return $this->headers;
    }
}
