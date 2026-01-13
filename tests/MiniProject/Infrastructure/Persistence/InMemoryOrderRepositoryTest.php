<?php

declare(strict_types=1);

namespace Tests\MiniProject\Infrastructure\Persistence;

use Ejercicios\MiniProject\Domain\Customer\Customer;
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
        $order = new Order(
            id: Uuid::fromString('ORDER_1'),
            customer: Customer::create('John Doe'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
        );

        $repository = new InMemoryOrderRepository();
        $repository->save($order);

        $found = $repository->find(Uuid::fromString('ORDER_1'));
        
        $this->assertEquals($order, $found);
    }

    public function testUpdatesOrder(): void
    {
        $order = new Order(
            id: Uuid::fromString('ORDER_1'),
            customer: Customer::create('John Doe'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
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
        $order = new Order(
            id: Uuid::fromString('ORDER_1'),
            customer: Customer::create('John Doe'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
        );

        $repository = new InMemoryOrderRepository();
        $repository->save($order);
        
        $found = $repository->find(Uuid::fromString('ORDER_2'));
        
        $this->assertNull($found);
    }

    public function testFindAllWithOrders(): void
    {
        $order = new Order(
            id: Uuid::fromString('ORDER_1'),
            customer: Customer::create('John Doe'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
        );

        $order2 = new Order(
            id: Uuid::fromString('ORDER_2'),
            customer: Customer::create('Jane Hopper'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
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
