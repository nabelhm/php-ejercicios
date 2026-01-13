<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Order;

use Ejercicios\MiniProject\Domain\Shared\Uuid;

interface OrderRepositoryInterface
{
    public function find(Uuid  $uuid): ?Order;
    public function save(Order $order): void;
    public function findAll(): array;
}
