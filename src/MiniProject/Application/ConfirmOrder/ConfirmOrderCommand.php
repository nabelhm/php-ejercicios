<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Application\ConfirmOrder;

final readonly class ConfirmOrderCommand
{
    public function __construct(public string $orderId)
    {
    }
}