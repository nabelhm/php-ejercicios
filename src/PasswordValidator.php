<?php

namespace Ejercicios;

class PasswordValidator
{
    public function validate(string $password): array
    {
        $errors = [];

        if (strlen($password) < 8) {
            $errors[] = 'under_8_char';
        }

        $hasLower = false;
        $hasUpper = false;
        $hasNumber = false;
        $hasSpecial = false;

        foreach (str_split($password) as $char) {
            if (!$hasNumber && is_numeric($char)) $hasNumber = true;
            if (!$hasLower && ctype_lower($char)) $hasLower = true;
            if (!$hasUpper && ctype_upper($char)) $hasUpper = true;
            if (!$hasSpecial && ctype_punct($char)) $hasSpecial = true;

            if ($hasNumber && $hasLower && $hasUpper && $hasSpecial) {
                break;
            }
        }

        if (!$hasNumber) $errors[]  = 'no_number';
        if (!$hasLower) $errors[]   = 'no_lower';
        if (!$hasUpper) $errors[]   = 'no_upper';
        if (!$hasSpecial) $errors[] = 'no_special_char';

        return [
            'valid' => empty($errors),
            'errors' => $errors
        ];
    }
}
