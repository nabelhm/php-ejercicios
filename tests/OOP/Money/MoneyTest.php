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
        $price = new Money(100 , Currency::EUR);

        $this->assertInstanceOf('Ejercicios\OOP\Money\Money', $price);
    }

    public function testAddMoney(): void
    {
        $price = new Money(100 , Currency::EUR);
        $newPrice = $price->add(200);

        $this->assertEquals(100, $price->getAmount());
        $this->assertEquals(Currency::EUR, $price->getCurrency());
        
        $this->assertEquals(300, $newPrice->getAmount());
        $this->assertEquals(Currency::EUR, $newPrice->getCurrency());
    }

    public function testSubstractMoney(): void
    {
        $price = new Money(100 , Currency::EUR);
        $newPrice = $price->subtract(50);

        $this->assertEquals(100, $price->getAmount());
        $this->assertEquals(Currency::EUR, $price->getCurrency());
        
        $this->assertEquals(50, $newPrice->getAmount());
        $this->assertEquals(Currency::EUR, $newPrice->getCurrency());
    }

    public function testSubstractMoneyException(): void
    {
        $price = new Money(100 , Currency::EUR);
        
        $this->expectException(InvalidArgumentException::class);
        $price->subtract(300);
    }

    public function testMutiplyMoney(): void
    {
        $price = new Money(100 , Currency::EUR);
        $newPrice = $price->multiply(1.5);

        $this->assertEquals(100, $price->getAmount());
        $this->assertEquals(Currency::EUR, $price->getCurrency());
        
        $this->assertEquals(150, $newPrice->getAmount());
        $this->assertEquals(Currency::EUR, $newPrice->getCurrency());
    }

    public function testDivideMoney(): void
    {
        $price = new Money(100 , Currency::EUR);
        $newPrice = $price->divide(2);

        $this->assertEquals(100, $price->getAmount());
        $this->assertEquals(Currency::EUR, $price->getCurrency());
        
        $this->assertEquals(50, $newPrice->getAmount());
        $this->assertEquals(Currency::EUR, $newPrice->getCurrency());
    }

    public function testDivideMoneyException(): void
    {
        $price = new Money(100 , Currency::EUR);
        
        $this->expectException(InvalidArgumentException::class);
        $price->divide(0);
    }

    public function testMoneyToString(): void
    {
        $price = new Money(100 , Currency::EUR);
        
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

        $this->expectException(Exception::class);
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

        $this->expectException(Exception::class);
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

        $this->expectException(Exception::class);
        $price->lessThan($newPrice);
    }
}