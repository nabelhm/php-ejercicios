<?php

declare(strict_types=1);

namespace Tests\MiniProject\Application\CreateOrder;

use Ejercicios\MiniProject\Application\CreateOrder\CreateOrderCommand;
use Ejercicios\MiniProject\Application\CreateOrder\CreateOrderHandler;
use Ejercicios\MiniProject\Application\CreateOrder\Exception\ProductNotFoundException;
use Ejercicios\MiniProject\Domain\Customer\Customer;
use Ejercicios\MiniProject\Domain\Customer\CustomerRepositoryInterface;
use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Product\ProductRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateOrderHandlerTest extends TestCase
{
    private Customer $customer;
    private Product $product;
    
    private MockObject $productRepository;
    private MockObject $customerRepository;
    private MockObject $orderRepository;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->customer = new Customer(
            Uuid::fromString('CUST_1'),
            'John Doe'
        );

        $this->product = new Product(
            id: Uuid::fromString('PROD_1'),
            name: 'table',
            price: new Money(1000, Currency::EUR)
        );

        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->customerRepository = $this->createMock(CustomerRepositoryInterface::class);
        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
    }

    public function testHandleCreatesOrderSuccessfully(): void
    {
        $command = new CreateOrderCommand(
            customerId: $this->customer->id()->value(),
            items: [
                [
                    'productId' => $this->product->id()->value(),
                    'quantity' => 2
                ]
            ]
        );

        $this->productRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->callback(fn($arg) => 
                $arg instanceof Uuid && $arg->value() === 'PROD_1'
            ))
            ->willReturn($this->product);

        $this->customerRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->callback(fn($arg) => 
                $arg instanceof Uuid && $arg->value() === 'CUST_1'
            ))
            ->willReturn($this->customer);

        $this->orderRepository
            ->expects($this->once())
            ->method('save');

        $handler = new CreateOrderHandler(
            $this->orderRepository,
            $this->productRepository,
            $this->customerRepository
        );

        // Act
        $orderId = $handler->handle($command);

        // Assert
        $this->assertInstanceOf(Uuid::class, $orderId);
    }

    public function testHandleThrowsExceptionWhenProductNotFound(): void
    {
        $command = new CreateOrderCommand(
            customerId: $this->customer->id()->value(),
            items: [
                [
                    'productId' => 'NONEXISTENT',
                    'quantity' => 1
                ]
            ]
        );
         $this->customerRepository
            ->expects($this->once())
            ->method('find')
            ->with($this->callback(fn($arg) => 
                $arg instanceof Uuid && $arg->value() === 'CUST_1'
            ))
            ->willReturn($this->customer);

        $this->productRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $handler = new CreateOrderHandler(
            $this->orderRepository,
            $this->productRepository,
            $this->customerRepository
        );

        $this->expectException(ProductNotFoundException::class);
        $this->expectExceptionMessage('There is no product with id NONEXISTENT');

        $handler->handle($command);
    }

    public function testHandleWithMultipleItems(): void
    {
        $product2 = new Product(
            id: Uuid::fromString('PROD_2'),
            name: 'chair',
            price: new Money(500, Currency::EUR)
        );

        $command = new CreateOrderCommand(
            customerId: $this->customer->id()->value(),
            items: [
                ['productId' => 'PROD_1', 'quantity' => 2],
                ['productId' => 'PROD_2', 'quantity' => 3]
            ]
        );

        $this->productRepository
            ->expects($this->exactly(2))
            ->method('find')
            ->willReturnCallback(function($id) use ($product2) {
                if ($id->value() === 'PROD_1') return $this->product;
                if ($id->value() === 'PROD_2') return $product2;
                return null;
            });

        $this->customerRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($this->customer);

        $this->orderRepository
            ->expects($this->once())
            ->method('save')
            ->with($this->callback(function($order) {
                // 1000*2 + 500*3 = 2000 + 1500 = 3500
                return $order->total()->amount === 3500;
            }));

        $handler = new CreateOrderHandler(
            $this->orderRepository,
            $this->productRepository,
            $this->customerRepository
        );

        $orderId = $handler->handle($command);

        $this->assertInstanceOf(Uuid::class, $orderId);
    }
}