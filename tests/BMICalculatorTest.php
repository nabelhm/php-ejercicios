<?php

namespace Tests;

use Ejercicios\BMICalculator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class BMICalculatorTest extends TestCase
{
    private BMICalculator $calculator;

    public static function bmiProvider(): array
    {
        return [
            [40, 1.60, 15.63, 'under_weight'],
            [50, 1.60, 19.53, 'normal'],
            [70, 1.60, 27.34, 'over_weight'],
            [80, 1.60, 31.25, 'obese'],
        ];
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new BMICalculator();
    }

    #[DataProvider('bmiProvider')]
    public function testUnderWeight(float $weight, float $height, float $expectedBmi, string $expectedCategory): void
    {
        ['bmi' => $actualBmi, 'category' => $actualCategory] =
            $this->calculator
            ->calculate($weight, $height);

        $this->assertEquals($expectedBmi, $actualBmi);
        $this->assertEquals($expectedCategory, $actualCategory);
    }
}
