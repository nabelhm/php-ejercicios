<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Validation\Validators;

use Ejercicios\OOP\Validation\ValidatorInterface;

class EmailValidator implements ValidatorInterface
{

    public function validate(mixed $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getError(): string
    {
        return 'Invalid email format';
    }
}
