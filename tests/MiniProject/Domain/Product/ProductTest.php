<?php

declare(strict_types=1);

namespace Tests\MiniProject\Domain\Product;

use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testConstruct(): void
    {
        $product = new Product(
            id: new Uuid('Prod_01'),
            name: 'table',
            price: new Money(1000, Currency::EUR)
        );

        $this->assertInstanceOf(Product::class, $product);
    }

    public function testPriceHigherThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);
        
        new Product(
            id: new Uuid('Prod_01'),
            name: 'table',
            price: new Money(0, Currency::EUR)
        );
    }

    public function testNameCanNotBeEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Product(
            id: new Uuid('Prod_01'),
            name: '',
            price: new Money(100, Currency::EUR)
        );
    }

    public function testCreate(): void
    {
        $product = Product::create(
            name: 'chair',
            priceAmount: 2000,
            currency: Currency::EUR
        );

        $this->assertInstanceOf(Product::class, $product);

        $this->assertInstanceOf(Uuid::class, $product->id());
        $this->assertEquals('chair', $product->name());
        $this->assertEquals(2000, $product->price()->amount);
        $this->assertEquals('EUR', $product->price()->currency->value);
    }

    public function testCreateSetEurAsCurrency(): void
    {
        $product = Product::create(
            name: 'chair',
            priceAmount: 2000,
        );

        $this->assertEquals('EUR', $product->price()->currency->value);
    }
}
