<?php

declare(strict_types=1);

namespace Tests\MiniProject\Application\ConfirmOrder;

use Ejercicios\MiniProject\Application\ConfirmOrder\ConfirmOrderCommand;
use Ejercicios\MiniProject\Application\ConfirmOrder\ConfirmOrderHandler;
use Ejercicios\MiniProject\Application\ConfirmOrder\ConfirmedOrderDto;
use Ejercicios\MiniProject\Application\ConfirmOrder\Exception\OrderNotFoundException;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Order\OrderStatus;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use DateTimeImmutable;
use Ejercicios\MiniProject\Domain\Customer\Customer;
use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class ConfirmOrderHandlerTest extends TestCase
{
    private MockObject $orderRepository;
    private ConfirmOrderHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $this->handler         = new ConfirmOrderHandler($this->orderRepository);
    }

    public function testHandleConfirmsOrderSuccessfully(): void
    {
        $orderId = 'ORDER_123';
        $order = new Order(
            id: Uuid::fromString($orderId),
            customer: Customer::create('CUST_1'),
            status: OrderStatus::PENDING,
            total: new Money(0, Currency::EUR),
            items: []
        );

        $command = new ConfirmOrderCommand($orderId);

        $this->orderRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->callback(
                fn($arg) =>
                $arg instanceof Uuid && $arg->value() === $orderId
            ))
            ->willReturn($order);

        $this->orderRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function ($savedOrder) {
                return $savedOrder instanceof Order
                    && $savedOrder->status() === OrderStatus::CONFIRMED;
            }));

        $result = $this->handler->handle($command);

        $this->assertInstanceOf(ConfirmedOrderDto::class, $result);
        $this->assertEquals($orderId, $result->orderId());
        $this->assertEquals('Confirmed', $result->orderStatus());
    }

    public function testHandleThrowsExceptionWhenOrderNotFound(): void
    {
        $orderId = 'NONEXISTENT';
        $command = new ConfirmOrderCommand($orderId);

        $this->orderRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->orderRepository
            ->expects($this->never())
            ->method('save');

        $this->expectException(OrderNotFoundException::class);
        $this->expectExceptionMessage("There is no order with id $orderId");

        $this->handler->handle($command);
    }
}
