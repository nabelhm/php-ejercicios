<?php

namespace Ejercicios;

class VowelCounter
{
    public function count(string $text): array
    {
        $total  = 0;
        $aTotal = 0;
        $eTotal = 0;
        $iTotal = 0;
        $oTotal = 0;
        $uTotal = 0;

        $lowerText = mb_strtolower($text, 'UTF-8');
        $arrayText = mb_str_split($lowerText, 1);
        foreach ($arrayText as $char) {
            if (in_array( $char,['a','á'])) {
                $aTotal ++;
                $total ++;
            };

            if (in_array( $char,['e','é'])) {
                $eTotal ++;
                $total ++;
            }
            
            if (in_array( $char,['i','í'])) {
                $iTotal ++;
                $total ++;
            }

            if (in_array( $char,['o','ó'])) {
                $oTotal ++;
                $total ++;
            }

            if (in_array( $char,['u','ú'])) {
                $uTotal ++;
                $total ++;
            }
        }

        return [
            'total' => $total,
            'vowels' => [
                'a' => $aTotal,
                'e' => $eTotal,
                'i' => $iTotal,
                'o' => $oTotal,
                'u' => $uTotal,
            ]
        ];
    }
}