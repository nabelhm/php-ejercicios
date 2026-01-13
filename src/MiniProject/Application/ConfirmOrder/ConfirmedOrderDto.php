<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ConfirmOrder;


final readonly class ConfirmedOrderDto
{
    public function __construct(private string $orderId, private string $orderStatus)
    {
    }

    public function orderId(): string
    {
        return $this->orderId;
    }

    public function orderStatus(): string
    {
        return $this->orderStatus;
    }
}