<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Validation;

interface ValidatorInterface
{
    public function validate(mixed $value): bool;
    public function getError(): string;
}
