<?php

declare(strict_types=1);

namespace Tests\MiniProject\Domain\Order;

use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Order\Exception\InvalidStateTransitionException;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderStatus;
use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertEmpty;

class OrderTest extends TestCase
{
    public function testConstruct(): void
    {
        $order = new Order(
            id: Uuid::fromString('ORDER_1'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
        );

        $this->assertInstanceOf(Order::class, $order);
    }

    public function testCreateWithDefaultsEmptyValues(): void
    {
        $order = Order::create();

        $this->assertInstanceOf(Uuid::class, $order->id());
        $this->assertEquals(OrderStatus::PENDING, $order->status());
        $this->assertEquals(0, $order->total()->amount);
        $this->assertEmpty($order->items());
    }

    public function testAddItem(): void
    {
        $product = Product::create(
            'water bottle',
            350
        );

        $order = Order::create();
        $order->addItem($product, 1);

        $this->assertEquals(350, $order->total()->amount);
    }

    public function testAddSeveralItems(): void
    {
        $product = Product::create(
            'water bottle',
            350
        );

        $order = Order::create();
        $order->addItem($product, 2);

        $product2 = Product::create(
            'coffee maker',
            650
        );

        $order->addItem($product2, 1);

        $this->assertEquals(1350, $order->total()->amount);
    }

    public function testConfirmFromPending(): void
    {
        $order = Order::create();
        $order->confirm();

        $this->assertEquals(OrderStatus::CONFIRMED, $order->status());
    }

    public function testShipFromConfirmed(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::CONFIRMED,
            new Money(0, Currency::EUR),
            []
        );
        $order->ship();

        $this->assertEquals(OrderStatus::SHIPPED, $order->status());
    }

    public function testDeliverFromShipped(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::SHIPPED,
            new Money(0, Currency::EUR),
            []
        );
        $order->deliver();

        $this->assertEquals(OrderStatus::DELIVERED, $order->status());
    }

    public function testCancelFromPending(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );
        $order->cancel();

        $this->assertEquals(OrderStatus::CANCELLED, $order->status());
    }

    public function testCancelFromConfirmed(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::CONFIRMED,
            new Money(0, Currency::EUR),
            []
        );
        $order->cancel();

        $this->assertEquals(OrderStatus::CANCELLED, $order->status());
    }

    // Transiciones inválidas (exceptions)
    public function testCannotConfirmFromConfirmed(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::CONFIRMED,
            new Money(0, Currency::EUR),
            []
        );
        $this->expectException(InvalidStateTransitionException::class);
        $order->confirm();
    }

    public function testCannotConfirmFromShipped(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::SHIPPED,
            new Money(0, Currency::EUR),
            []
        );
        $this->expectException(InvalidStateTransitionException::class);
        $order->confirm();
    }

    public function testCannotConfirmFromDelivered(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::DELIVERED,
            new Money(0, Currency::EUR),
            []
        );

        $this->expectException(InvalidStateTransitionException::class);
        $order->confirm();
    }

    public function testCannotShipFromPending(): void
    {
       $order = new Order(
            Uuid::generate(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );
        $this->expectException(InvalidStateTransitionException::class);
        $order->ship();
    }

    public function testCannotDeliverFromPending(): void
    {
       $order = new Order(
            Uuid::generate(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );
        $this->expectException(InvalidStateTransitionException::class);
        $order->deliver();
    }

    public function testCannotCancelFromShipped(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::SHIPPED,
            new Money(0, Currency::EUR),
            []
        );
        $this->expectException(InvalidStateTransitionException::class);
        $order->cancel();
    }

    public function testCannotCancelFromDelivered(): void
    {
        $order = new Order(
            Uuid::generate(),
            OrderStatus::DELIVERED,
            new Money(0, Currency::EUR),
            []
        );
        $this->expectException(InvalidStateTransitionException::class);
        $order->cancel();
    }
}
