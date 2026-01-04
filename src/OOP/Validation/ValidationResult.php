<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Validation;

class ValidationResult
{
    public function __construct(
        private bool $valid,
        private array $errors = []
    ) {}

    public function isValid(): bool
    {
        return $this->valid;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
