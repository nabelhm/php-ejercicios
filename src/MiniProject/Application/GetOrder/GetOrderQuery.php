<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\GetOrder;

final readonly class GetOrderQuery
{
    public function __construct(public string $orderId) {}
}
