<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\GetOrder;

final readonly class OrderItemDto
{
    public function __construct(
        public string $productId,
        public int $quantity,
        public int $subtotalAmount,
        public string $currency,
    ) {}
}
