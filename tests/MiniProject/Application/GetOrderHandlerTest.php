<?php

declare(strict_types=1);

namespace Tests\MiniProject\Application;

use DateTimeImmutable;
use Ejercicios\MiniProject\Application\GetOrder\GetOrderHandler;
use Ejercicios\MiniProject\Application\GetOrder\GetOrderQuery;
use Ejercicios\MiniProject\Application\GetOrder\OrderDto;
use Ejercicios\MiniProject\Application\Shared\Exception\OrderNotFoundException;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Order\OrderStatus;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetOrderHandlerTest extends TestCase
{
    private MockObject $orderRepository;
    private GetOrderHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $this->handler         = new GetOrderHandler($this->orderRepository);
    }

    public function testHandleGetOrderSuccessfully(): void
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

        $query = new GetOrderQuery($orderId);

        $this->orderRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->callback(
                fn($arg) =>
                $arg instanceof Uuid && $arg->value() === $orderId
            ))
            ->willReturn($order);

        $result = $this->handler->handle($query);

        $this->assertInstanceOf(OrderDto::class, $result);
        $this->assertEquals($orderId, $result->id);
        $this->assertEquals('Pending', $result->status);
    }

    public function testHandleThrowsExceptionWhenOrderNotFound(): void
    {
        $orderId = 'NONEXISTENT';
        $query = new GetOrderQuery($orderId);

        $this->orderRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException(OrderNotFoundException::class);
        $this->expectExceptionMessage("There is no order with id $orderId");

        $this->handler->handle($query);
    }
}
