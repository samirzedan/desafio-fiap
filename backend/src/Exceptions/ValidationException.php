<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends Exception
{
    protected array $errors = [];

    public function __construct(array $errors)
    {
        parent::__construct("Validation failed", 422);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function toArray(): array
    {
        return [
            'message' => $this->getMessage(),
            'errors' => $this->errors,
        ];
    }
}
