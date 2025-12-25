<?php

namespace Ejercicios;

class BMICalculator
{
    public function calculate(float $weight, float $height): array
    {
        $bmi = $weight / ($height * $height);

        switch (true) {
            case $bmi < 18.5:
                $category = 'under_weight';
                break;
            case $bmi >= 18.5 && $bmi < 25:
                $category = 'normal';
                break;
            case $bmi >= 25 && $bmi < 30:
                $category = 'over_weight';
                break;
            case $bmi > 30:
                $category = 'obese';
                break;
            default:
                break;
        };

        return [
            'bmi' => round($bmi, 2),
            'category' => $category
        ];
    }
}
