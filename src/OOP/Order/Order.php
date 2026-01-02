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
    
    public function confirm(): self
    {
        if (!$this->status->canTransitionTo(OrderStatus::CONFIRMED)) {
            throw new InvalidStateTransitionException("Status must be Pending");
        };
          
        return new Order(
            id: $this->id,
            status: OrderStatus::CONFIRMED,
            createdAt: $this->createdAt
        );
    }

    public function ship(): self
    {
        if (!$this->status->canTransitionTo(OrderStatus::SHIPPED)) {
            throw new InvalidStateTransitionException("Status must be Confirmed");
        };
          
        return new Order(
            id: $this->id,
            status: OrderStatus::SHIPPED,
            createdAt: $this->createdAt
        );
    }

    public function deliver(): self
    {
        if (!$this->status->canTransitionTo(OrderStatus::DELIVERED)) {
            throw new InvalidStateTransitionException("Status must be Shipped");
        };
          
        return new Order(
            id: $this->id,
            status: OrderStatus::DELIVERED,
            createdAt: $this->createdAt
        );
    }

    public function cancel(): self
    {
        if (!$this->status->canTransitionTo(OrderStatus::CANCELLED)) {
            throw new InvalidStateTransitionException("Status must be Pending or Confirmed");
        };
          
        return new Order(
            id: $this->id,
            status: OrderStatus::CANCELLED,
            createdAt: $this->createdAt
        );
    }
}