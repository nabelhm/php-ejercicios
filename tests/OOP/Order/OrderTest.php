<?php

namespace Tests\OOP\Order;

use DateTimeImmutable;
use Ejercicios\OOP\Order\InvalidStateTransitionException;
use Ejercicios\OOP\Order\Order;
use Ejercicios\OOP\Order\OrderStatus;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{

    public function testCreateOrder(): void
    {
        // Constructor directo para tests (ID conocido)
        $order = new Order('ORD-001', OrderStatus::PENDING, new DateTimeImmutable());

        $this->assertEquals('ORD-001', $order->id);
        $this->assertEquals(OrderStatus::PENDING, $order->status);
    }

    public function testCreateOrderViaFactory(): void
    {
        // Factory para código de producción
        $order = Order::create(OrderStatus::PENDING);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertNotEmpty($order->id);
        $this->assertEquals(OrderStatus::PENDING, $order->status);
    }

    // Transiciones válidas
    public function testConfirmFromPending(): void
    {
        $order = Order::create(OrderStatus::PENDING);
        $newOrder = $order->confirm();

        $this->assertEquals(OrderStatus::CONFIRMED, $newOrder->status);
    }


    public function testShipFromConfirmed(): void
    {
        $order = Order::create(OrderStatus::CONFIRMED);
        $newOrder = $order->ship();

        $this->assertEquals(OrderStatus::SHIPPED, $newOrder->status);
    }

    public function testDeliverFromShipped(): void
    {
        $order = Order::create(OrderStatus::SHIPPED);
        $newOrder = $order->deliver();

        $this->assertEquals(OrderStatus::DELIVERED, $newOrder->status);
    }

    public function testCancelFromPending(): void
    {
        $order = Order::create(OrderStatus::PENDING);
        $newOrder = $order->cancel();

        $this->assertEquals(OrderStatus::CANCELLED, $newOrder->status);
    }

    public function testCancelFromConfirmed(): void
    {
        $order = Order::create(OrderStatus::CONFIRMED);
        $newOrder = $order->cancel();

        $this->assertEquals(OrderStatus::CANCELLED, $newOrder->status);
    }

    // Transiciones inválidas (exceptions)
    public function testCannotConfirmFromConfirmed(): void
    {
        $order = Order::create(OrderStatus::CONFIRMED);
        $this->expectException(InvalidStateTransitionException::class);
        $order->confirm();
    }

    public function testCannotConfirmFromShipped(): void
    {
        $order = Order::create(OrderStatus::SHIPPED);
        $this->expectException(InvalidStateTransitionException::class);
        $order->confirm();
    }

    public function testCannotConfirmFromDelivered(): void
    {
        $order = Order::create(OrderStatus::DELIVERED);
        $this->expectException(InvalidStateTransitionException::class);
        $order->confirm();
    }

    public function testCannotShipFromPending(): void
    {
        $order = Order::create(OrderStatus::PENDING);
        $this->expectException(InvalidStateTransitionException::class);
        $order->ship();
    }

    public function testCannotDeliverFromPending(): void
    {
        $order = Order::create(OrderStatus::PENDING);
        $this->expectException(InvalidStateTransitionException::class);
        $order->deliver();
    }

    public function testCannotCancelFromShipped(): void
    {
        $order = Order::create(OrderStatus::SHIPPED);
        $this->expectException(InvalidStateTransitionException::class);
        $order->cancel();
    }

    public function testCannotCancelFromDelivered(): void
    {
        $order = Order::create(OrderStatus::DELIVERED);
        $this->expectException(InvalidStateTransitionException::class);
        $order->cancel();
    }

    // Immutability
    public function testConfirmReturnsNewInstance(): void
    { 
        $order = Order::create(OrderStatus::PENDING);
        $confirmedOrder = $order->confirm();

        $this->assertNotSame($order, $confirmedOrder);
    }

    public function testOriginalOrderUnchangedAfterConfirm(): void
    {
        $order = Order::create(OrderStatus::PENDING);
        $confirmedOrder = $order->confirm();

        $this->assertEquals(OrderStatus::PENDING, $order->status);
        $this->assertEquals(OrderStatus::CONFIRMED, $confirmedOrder->status);
    }

    // Enum canTransitionTo
    public function testCanTransitionFromPendingToConfirmed(): void
    {
        $this->assertTrue(OrderStatus::PENDING->canTransitionTo(OrderStatus::CONFIRMED));
    }

    public function testCannotTransitionFromDeliveredToAnything(): void
    {
        $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::PENDING));
        $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::CONFIRMED));
        $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::SHIPPED));
        $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::DELIVERED));
        $this->assertFalse(OrderStatus::DELIVERED->canTransitionTo(OrderStatus::CANCELLED));
    }
}
