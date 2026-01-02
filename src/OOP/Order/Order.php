<?php

namespace Ejercicios\OOP\Order;

use DateTimeImmutable;

class Order
{
    public function __construct(
        public readonly string $id,
        public readonly OrderStatus $status,
        public readonly DateTimeImmutable $createdAt
    ) {}
    
    public static function create(OrderStatus $status): self
    {
        return new self(
            id: uniqid('ORD-'),
            status: $status,
            createdAt: new DateTimeImmutable()
        );
    }
    
    private function transitionTo(OrderStatus $newStatus): self
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw new InvalidStateTransitionException(
                "Cannot transition from {$this->status->value} to {$newStatus->value}"
            );
        }
        
        return new Order(
            id: $this->id,
            status: $newStatus,
            createdAt: $this->createdAt
        );
    }

    public function confirm(): self
    {
        return $this->transitionTo(OrderStatus::CONFIRMED);
    }

    public function ship(): self
    {
        return $this->transitionTo(OrderStatus::SHIPPED);
    }

    public function deliver(): self
    {
        return $this->transitionTo(OrderStatus::DELIVERED);
    }

    public function cancel(): self
    {
        return $this->transitionTo(OrderStatus::CANCELLED);
    }
}