<?php

namespace Tests;

use Ejercicios\ArrayAnalyzer;
use InvalidArgumentException;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class ArrayAnalyzerTest extends TestCase
{
    private ArrayAnalyzer $analyzer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->analyzer = new ArrayAnalyzer();
    }

    public static function arrayAnalizeProvider(): array
    {
        return [
            [[1, 2, 3, 4, 5], 15,  3.00,  1,  5, 5],
            [[10],            10, 10.00, 10, 10, 1],
            [[-5, 0, 5],       0,  0.00, -5,  5, 3],
        ];
    }

    public function testEmptyArrayThrowException(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $this->analyzer->analyze([]);
    }

    #[DataProvider('arrayAnalizeProvider')]
    public function testAnalizeArray(
        array $numbers,
        int $expectedSum,
        float $expectedAverage,
        int $expectedMin,
        int $expectedMax,
        int $expectedCount
    ): void {
        
        $expectedResult = [
            'sum' => $expectedSum,        
            'average' => $expectedAverage,
            'min' => $expectedMin,        
            'max' => $expectedMax,        
            'count' => $expectedCount
        ];

        $actualResult = $this->analyzer->analyze($numbers);

        $this->assertEquals($expectedResult, $actualResult);
    }
}
