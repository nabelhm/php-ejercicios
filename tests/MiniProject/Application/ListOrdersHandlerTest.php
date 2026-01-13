<?php

declare(strict_types=1);

namespace Tests\MiniProject\Application;

use DateTimeImmutable;
use Ejercicios\MiniProject\Application\ListOrders\ListOrdersHandler;
use Ejercicios\MiniProject\Application\ListOrders\ListOrdersQuery;
use Ejercicios\MiniProject\Application\ListOrders\OrderSummaryDTO;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Order\OrderStatus;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ListOrdersHandlerTest extends TestCase
{
    private MockObject $orderRepository;
    private ListOrdersHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $this->handler         = new ListOrdersHandler($this->orderRepository);
    }

    public function testHandleLisOrdersSuccessfully(): void
    {
        $orderId = 'ORDER_123';
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

        $query = new ListOrdersQuery();

        $this->orderRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([$order, $order2]);

        $result = $this->handler->handle($query);

        $this->assertCount(2, $result);
        $this->assertInstanceOf(OrderSummaryDTO::class, $result[0]);
    }

    public function testHandleReturnsEmptyArrayWhenNoOrders(): void
    {
       $query = new ListOrdersQuery();

        $this->orderRepository
            ->expects($this->once())
            ->method('findAll')
            ->willReturn([]);

        $result = $this->handler->handle($query);
        $this->assertEmpty($result);
    }
}
