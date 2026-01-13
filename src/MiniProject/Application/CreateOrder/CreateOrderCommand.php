<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\CreateOrder;

final readonly class CreateOrderCommand
{
    /**
     * @param string $customerId
     * @param array<array{productId: string, quantity: int}> $items
     */
    public function __construct(public string $customerId, public array $items)
    {
    }
}