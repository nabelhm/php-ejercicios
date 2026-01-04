<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Validation\Validators;

use Ejercicios\OOP\Validation\ValidatorInterface;

class RegexValidator implements ValidatorInterface
{
    public function __construct(private string $pattern) {}

    public function validate(mixed $value): bool
    {
        return (bool) preg_match($this->pattern, $value);
    }

    public function getError(): string
    {
        return 'Value does not match required pattern';
    }
}
