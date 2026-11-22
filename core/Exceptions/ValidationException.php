<?php
namespace Core\Exceptions;

use RuntimeException;

class ValidationException extends RuntimeException {
    public function __construct(protected array $errors = []) {
        parent::__construct('Os dados enviados são inválidos.');
    }

    public function errors(): array {
        return $this->errors;
    }
}
