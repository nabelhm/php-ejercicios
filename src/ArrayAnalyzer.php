<?php

namespace Ejercicios;

use InvalidArgumentException;

class ArrayAnalyzer
{
    public function analyze(array $numbers): array
    {
        if (empty($numbers)) {
            throw new InvalidArgumentException("Array cannot be empty");
        }

        $sum = array_sum($numbers);
        $count = count($numbers);

        return [
            'sum' => $sum,
            'average' => round($sum / $count, 2),
            'min' => min($numbers),
            'max' => max($numbers),
            'count' => $count
        ];
    }
}
