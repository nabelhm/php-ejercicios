<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ListOrders;

final readonly class OrderSummaryDTO
{
    public function __construct(
        public string $orderId,
        public string $customerId,
        public string $status,
        public int $totalAmount,
        public string $totalCurrency,
        public int $itemCount,
        public string $createdAt
    ) {}
}