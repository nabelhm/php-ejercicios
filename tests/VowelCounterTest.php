<?php

namespace Tests;

use Ejercicios\VowelCounter;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEquals;

class VowelCounterTest extends TestCase
{
    private VowelCounter $counter;

    protected function setUp(): void
    {
        parent::setUp();
        $this->counter = new VowelCounter();
    }

    public static function vowelCountProvider(): array
    {
        return [
            ["Hola Mundo", 4, 1, 0, 0, 2, 1],
            ["Programación", 5, 2, 0, 1, 2, 0],
            ["123!@#", 0, 0, 0, 0, 0, 0]
        ];
    }

    #[DataProvider('vowelCountProvider')]
    public function testCountVowels(
        string $text,
        int $expectedTotalCount,
        int $expectedACount,
        int $expectedECount,
        int $expectedICount,
        int $expectedOCount,
        int $expectedUCount
    ): void {

        [
            'total' => $actualTotalCount,
            'vowels' => $actualVowels
        ] = $this->counter->count($text);

        [
            'a' => $actualACount,
            'e' => $actualECount,
            'i' => $actualICount,
            'o' => $actualOCount,
            'u' => $actualUCount
        ] = $actualVowels;

        $this->assertEquals($expectedTotalCount, $actualTotalCount);
        $this->assertEquals($expectedACount, $actualACount);
        $this->assertEquals($expectedECount, $actualECount);
        $this->assertEquals($expectedICount, $actualICount);
        $this->assertEquals($expectedOCount, $actualOCount);
        $this->assertEquals($expectedUCount, $actualUCount);
    }
}
