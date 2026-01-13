<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ConfirmOrder;


final readonly class ConfirmedOrderDto
{
    public function __construct(public string $orderId, public string $orderStatus)
    {
    }
}