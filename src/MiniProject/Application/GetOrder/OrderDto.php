<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\GetOrder;

final readonly class OrderDto
{

    /**
     * @param OrderItemDto[] $items
     */
    public function __construct(
        public string $id,
        public string $customerId,
        public string $createdAt,
        public string $status,
        public int $totalAmount,
        public string $currency,
        public array $items
    ) {}
}
