<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Validation\Validators;

use Ejercicios\OOP\Validation\ValidatorInterface;

class LengthValidator implements ValidatorInterface
{
    public function __construct(private ?int $min = null, private ?int $max = null) {}

    public function validate(mixed $value): bool
    {
        $length = is_string($value) ? strlen($value) : count($value);

        $validMin = true;
        if ($this->min !== null) {
            $validMin = $this->min <= $length;
        }

        $validMax = true;
        if ($this->max !== null) {
            $validMax = $length <= $this->max;
        }

        return  $validMin && $validMax;
    }

    public function getError(): string
    {
        if ($this->min !== null && $this->max !== null) {
            return "Length must be between {$this->min} and {$this->max}";
        }
        if ($this->min !== null) {
            return "Length must be at least {$this->min}";
        }
        if ($this->max !== null) {
            return "Length must be at most {$this->max}";
        }
        return "Invalid length";
    }
}
