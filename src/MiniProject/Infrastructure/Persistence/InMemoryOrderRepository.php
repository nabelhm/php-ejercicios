<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Infrastructure\Persistence;

use Ejercicios\MiniProject\Domain\Order\Order;
use Ejercicios\MiniProject\Domain\Order\OrderRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

class InMemoryOrderRepository implements OrderRepositoryInterface
{
    /**
     * @var array<string, Order>
     */
    private array $orders = [];

    public function find(Uuid  $id): ?Order
    {
        return $this->orders[$id->value()] ?? null;
    }

    public function save(Order $order): void
    {
        $this->orders[$order->id()->value()] = $order;
    }

    public function findAll(): array
    {
        return array_values($this->orders);
    }
}
