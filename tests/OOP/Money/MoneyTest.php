<?php

namespace Tests\OOP\Money;

use Ejercicios\OOP\Money\Currency;
use Ejercicios\OOP\Money\Money;
use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\equalTo;

class MoneyTest extends TestCase
{
    public function testCreateMoney(): void
    {
        $price = new Money(100, Currency::EUR);

        $this->assertInstanceOf('Ejercicios\OOP\Money\Money', $price);
    }

    public function testAddMoney(): void
    {
        $price1 = new Money(100, Currency::EUR);
        $price2 = new Money(200, Currency::EUR);
        $result = $price1->add($price2);

        $this->assertEquals(300, $result->amount);
        $this->assertEquals(100, $price1->amount); // immutability
    }

    public function testAddDifferentCurrenciesThrowsException(): void
    {
        $eur = new Money(100, Currency::EUR);
        $usd = new Money(100, Currency::USD);

        $this->expectException(InvalidArgumentException::class);
        $eur->add($usd);
    }

    public function testFromString(): void
    {
        $money = Money::fromString("100.50 EUR");

        $this->assertEquals(10050, $money->amount); // 100.50 EUR = 10050 cents
        $this->assertEquals(Currency::EUR, $money->currency);
    }

    public function testSubstractMoney(): void
    {
        $price = new Money(100, Currency::EUR);
        $price2 = new Money(50, Currency::EUR);

        $result = $price->subtract($price2);

        $this->assertEquals(100, $price->amount);
        $this->assertEquals(50, $result->amount);
    }

    public function testSubstractMoneyException(): void
    {
        $price = new Money(100, Currency::EUR);
        $price2 = new Money(150, Currency::EUR);

        $this->expectException(InvalidArgumentException::class);
        $price->subtract($price2);
    }

    public function testMutiplyMoney(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = $price->multiply(2);

        $this->assertEquals(100, $price->amount);

        $this->assertEquals(200, $newPrice->amount);
        $this->assertEquals(Currency::EUR, $newPrice->currency);
    }

    public function testDivideMoney(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = $price->divide(2);

        $this->assertEquals(100, $price->amount);
        $this->assertEquals(Currency::EUR, $price->currency);

        $this->assertEquals(50, $newPrice->amount);
        $this->assertEquals(Currency::EUR, $newPrice->currency);
    }

    public function testDivideMoneyException(): void
    {
        $price = new Money(100, Currency::EUR);

        $this->expectException(InvalidArgumentException::class);
        $price->divide(0);
    }

    public function testMoneyToString(): void
    {
        $price = new Money(100, Currency::EUR);

        $this->assertEquals('1.00 EUR', $price->__toString());
    }

    public function testEqualsTrue(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(100, Currency::EUR);

        $this->assertTrue($price->equals($newPrice));
    }

    public function testEqualsFalse(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(199, Currency::EUR);

        $this->assertFalse($price->equals($newPrice));
    }

    public function testEqualsException(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(100, Currency::USD);

        $this->expectException(InvalidArgumentException::class);
        $price->equals($newPrice);
    }

    public function testGreaterThanTrue(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(50, Currency::EUR);

        $this->assertTrue($price->greaterThan($newPrice));
    }

    public function testGreaterThanFalse(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(200, Currency::EUR);

        $this->assertFalse($price->greaterThan($newPrice));
    }

    public function testGreaterThanException(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(100, Currency::USD);

        $this->expectException(InvalidArgumentException::class);
        $price->greaterThan($newPrice);
    }

    public function testLessThanTrue(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(200, Currency::EUR);

        $this->assertTrue($price->lessThan($newPrice));
    }

    public function testLessThanFalse(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(50, Currency::EUR);

        $this->assertFalse($price->lessThan($newPrice));
    }

    public function testLessThanException(): void
    {
        $price = new Money(100, Currency::EUR);
        $newPrice = new Money(100, Currency::USD);

        $this->expectException(InvalidArgumentException::class);
        $price->lessThan($newPrice);
    }

    public function testNegativeAmountThrowsException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Money(-100, Currency::EUR);
    }

    public function testFromStringInvalidFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        Money::fromString("invalid");
    }
}
