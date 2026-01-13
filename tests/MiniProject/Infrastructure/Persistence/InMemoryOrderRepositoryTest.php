<?php

declare(strict_types=1);

namespace Tests\MiniProject\Infrastructure\Persistence;

use DateTimeImmutable;
use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderStatus;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Infrastructure\Persistence\InMemoryOrderRepository;
use PHPUnit\Framework\TestCase;

class InMemoryOrderRepositoryTest extends TestCase
{
    public function testSavesAndFindOrder(): void
    {
        $orderId = 'ORDER_1';
        $order = new Order(
            Uuid::fromString($orderId),
            Uuid::fromString('CUST_123'),
            new DateTimeImmutable(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );

        $repository = new InMemoryOrderRepository();
        $repository->save($order);

        $found = $repository->find(Uuid::fromString($orderId));
        
        $this->assertEquals($order, $found);
    }

    public function testUpdatesOrder(): void
    {
        $orderId = 'ORDER_1';
        $order = new Order(
            Uuid::fromString($orderId),
            Uuid::fromString('CUST_123'),
            new DateTimeImmutable(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );

        $repository = new InMemoryOrderRepository();
        $repository->save($order);

        $order->confirm();
        $repository->save($order);
        
        $found = $repository->find(Uuid::fromString('ORDER_1'));
        
        $this->assertEquals(OrderStatus::CONFIRMED, $found->status());
    }


    public function testReturNullOnNonExistentOrder(): void
    {
        $orderId = 'ORDER_1';
        $order = new Order(
            Uuid::fromString($orderId),
            Uuid::fromString('CUST_123'),
            new DateTimeImmutable(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );

        $repository = new InMemoryOrderRepository();
        $repository->save($order);
        
        $found = $repository->find(Uuid::fromString('ORDER_2'));
        
        $this->assertNull($found);
    }

    public function testFindAllWithOrders(): void
    {
        $orderId = 'ORDER_1';
        $order = new Order(
            Uuid::fromString($orderId),
            Uuid::fromString('CUST_123'),
            new DateTimeImmutable(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );

        $order2 = new Order(
            Uuid::fromString('ORDER_2'),
            Uuid::fromString('CUST_123'),
            new DateTimeImmutable(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );

        $repository = new InMemoryOrderRepository();
        $repository->save($order);
        $repository->save($order2);
        
        $found = $repository->findAll();
        
        $this->assertCount(2, $found);
        $this->assertContains($order, $found);
        $this->assertContains($order2, $found);
    }

    public function testFindAllReturnEmptyWithNoOrders(): void
    {
        $repository = new InMemoryOrderRepository();
        $found = $repository->findAll();
        
        $this->assertEmpty($found);
    }
}
