<?php

namespace Ejercicios;

class FizzBuzz
{
    public function convert(int $number): int|string
    {
        if (0 === $number % 15) {
            return "FizzBuzz";
        }

        if (0 === $number % 3) {
            return "Fizz";
        }

        if (0 === $number % 5) {
            return "Buzz";
        }

        return (string) $number;
    }
}
