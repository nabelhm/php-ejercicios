<?php

declare(strict_types=1);

namespace Tests\MiniProject\Domain\Order;

use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Order\OrderItem;
use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class OrderItemTest extends TestCase
{

    private Product $product;

    protected function setUp(): void
    {
        $this->product = new Product(
            id: new Uuid('PROD_1'),
            name: 'chair',
            price: new Money(2000, Currency::EUR)
        );
    }

    public function testConstruct(): void
    {
        $orderItem = new OrderItem(
            $this->product,
            2
        );

        $this->assertInstanceOf(OrderItem::class, $orderItem);
    }

    public function testQuantityHigherThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new OrderItem(
            $this->product,
            0
        );
    }
}
