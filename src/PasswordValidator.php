<?php

namespace Ejercicios;

class PasswordValidator
{
    public function validate(string $password): array
    {
        $errors = [];
        
        $lower       = 0;
        $upper       = 0;
        $number      = 0;
        $specialChar = 0;
        
        if (8 > strlen($password)) {
            $errors [] = 'under_8_char';
        }

        $array = str_split($password);
        foreach ($array as $char) {
            if ((0 === $number) && is_numeric($char)) {
                $number ++;
            }

            if ((0 === $lower) && ctype_lower($char)) {
                $lower ++;
            }

            if ((0 === $upper) && ctype_upper($char)) {
                $upper ++;
            }

            if ((0 === $specialChar) && ctype_punct($char)) {
                $specialChar ++;
            }
        }

        if (0 === $number) {
            $errors [] = 'no_number';
        }
        
        if (0 === $lower) {
            $errors [] = 'no_lower';
        }
        
        if (0 === $upper) {
            $errors [] = 'no_upper';
        }

        if (0 === $specialChar) {
            $errors [] = 'no_special_char';
        }

        return [
            'valid' => 0 === count($errors),
            'errors' => $errors
        ];
    }   
    
    public function validateAlternate(string $password): array
    {
        $errors = [];

        if (8 > strlen($password)) {
            $errors [] = 'under_8_char';
        }

        $lowerPassword = strtolower($password);
        if ($lowerPassword === $password) {
            $errors [] = 'no_upper';
        }

        $upperPassword = strtoupper($password);
        if ($upperPassword === $password) {
            $errors [] = 'no_lower';
        }

        return [
            'valid' => 0 === count($errors),
            'errors' => $errors
        ];
    }
}