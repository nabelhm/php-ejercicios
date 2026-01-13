<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\CreateOrder;

use DateTimeImmutable;
use Ejercicios\MiniProject\Application\CreateOrder\Exception\ProductNotFoundException;
use Ejercicios\MiniProject\Application\CreateOrder\Exception\CustomerNotFoundException;
use Ejercicios\MiniProject\Domain\Customer\CustomerRepositoryInterface;
use Ejercicios\MiniProject\Domain\Event\OrderCreated;
use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Product\ProductRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Infrastructure\Event\EventDispatcherInterface;

final class CreateOrderHandler
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ProductRepositoryInterface $productRepository,
        private CustomerRepositoryInterface $customerRepository,
        private EventDispatcherInterface $eventDispatcher
    ) {}

    public function handle(CreateOrderCommand $command): Uuid
    {
        $customerId = $command->customerId;
        $customer = $this->customerRepository->find(Uuid::fromString($customerId));
        if (null === $customer) {
            throw new CustomerNotFoundException("There is no customer with id $customerId");
        }

        $itemsData  = $command->items;
        $productsData = [];
        foreach ($itemsData as $item) {
            $productId = $item['productId'];
            $product = $this->productRepository->find(Uuid::fromString($productId));

            if (null === $product) {
                throw new ProductNotFoundException("There is no product with id $productId");
            }

            $productsData[] =  [
                'product'  => $product,
                'quantity' => $item['quantity']
            ];
        }

        $order = Order::create(
            Uuid::fromString($command->customerId)
        );

        foreach ($productsData as $item) {
            $order->addItem(...$item);
        }

        $this->orderRepository->save($order);

        $this->eventDispatcher->dispatch(
            new OrderCreated(
                $order->id(),
                $order->customerId(),
                new DateTimeImmutable()
            )
        );

        return $order->id();
    }
}
