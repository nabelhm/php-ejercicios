<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Order;

enum OrderStatus: string
{
    case PENDING   = 'Pending';
    case CONFIRMED = 'Confirmed';
    case SHIPPED   = 'Shipped';
    case DELIVERED = 'Delivered';
    case CANCELLED = 'Cancelled';


    public function canTransitionTo(OrderStatus $status): bool
    {
        $validTransitions = match ($this) {
             OrderStatus::PENDING => [OrderStatus::CONFIRMED, OrderStatus::CANCELLED],
             OrderStatus::CONFIRMED => [OrderStatus::SHIPPED, OrderStatus::CANCELLED],
             OrderStatus::SHIPPED => [OrderStatus::DELIVERED],
             OrderStatus::DELIVERED => [],
             OrderStatus::CANCELLED => [],
        };

        return in_array($status, $validTransitions); 
    }
}