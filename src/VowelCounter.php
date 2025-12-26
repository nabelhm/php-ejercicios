<?php

namespace Ejercicios;

class VowelCounter
{
    public function count(string $text): array
    {
        $vowels = [
            'a' => ['a', 'á', 'à', 'ä', 'â'],
            'e' => ['e', 'é', 'è', 'ë', 'ê'],
            'i' => ['i', 'í', 'ì', 'ï', 'î'],
            'o' => ['o', 'ó', 'ò', 'ö', 'ô'],
            'u' => ['u', 'ú', 'ù', 'ü', 'û'],
        ];

        $counts = [
            'a' => 0,
            'e' => 0,
            'i' => 0,
            'o' => 0,
            'u' => 0,
        ];

        $lowerText = mb_strtolower($text, 'UTF-8');
        $length = mb_strlen($lowerText, 'UTF-8');

        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($lowerText, $i, 1, 'UTF-8');
            
            foreach ($vowels as $vowel => $variants) {
                if (in_array($char, $variants)) {
                    $counts[$vowel]++;
                }
            }
        }

        $total = array_sum($counts);

        return [
            'total' => $total,
            'vowels' => $counts
        ];
    }
}