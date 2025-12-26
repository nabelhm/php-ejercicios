<?php

namespace Ejercicios;

use InvalidArgumentException;

class ArrayAnalyzer
{
    public function analyze(array $numbers): array
    {

        if (empty($numbers)) {
            throw new InvalidArgumentException("Empty Array");
        }

        $counters = [
            'sum' => 0,        // Suma de todos los números
            'average' => 0,    // Promedio (redondeado a 2 decimales)
            'min' => 0,        // Valor mínimo
            'max' => 0,        // Valor máximo
            'count' => 0       // Cantidad de elementos
        ];

        $counters['sum'] = array_sum($numbers);
        $counters['count'] = count($numbers);
        $counters['average'] = round($counters['sum'] / $counters['count'], 2);
        $counters['max'] = max($numbers);
        $counters['min'] = min($numbers);

        return $counters;
    }
}
