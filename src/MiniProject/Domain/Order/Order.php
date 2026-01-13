<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Order;

use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Order\Exception\InvalidOrderStateException;
use Ejercicios\MiniProject\Domain\Order\Exception\InvalidStateTransitionException;
use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use DateTimeImmutable;

class Order
{
    /**
     * @param OrderItem[] $items
     */
    public function __construct(
        private readonly Uuid $id,
        private readonly Uuid $customerId,  // ← CORRECTO: Solo ID
        private readonly DateTimeImmutable $createdAt,
        private OrderStatus $status,
        private Money $total,
        private array $items
    ) {}

    public static function create(
        Uuid $customerId,  // ← CORRECTO: Solo ID
    ): self {
        return new self(
            Uuid::generate(),
            $customerId,
            new DateTimeImmutable(),
            OrderStatus::PENDING,
            new Money(0, Currency::EUR),
            []
        );
    }

    public function addItem(Product $product, int $quantity): void
    {
        if ($this->status !== OrderStatus::PENDING) {
            throw new InvalidOrderStateException(
                "Can not add items to an order in status {$this->status->value}"
            );
        }

        $this->items[] = new OrderItem($product, $quantity);
        $this->recalculateTotal();
    }

    public function confirm(): void
    {
        $this->transitionTo(OrderStatus::CONFIRMED);
    }

    public function ship(): void
    {
        $this->transitionTo(OrderStatus::SHIPPED);
    }

    public function deliver(): void
    {
        $this->transitionTo(OrderStatus::DELIVERED);
    }

    public function cancel(): void
    {
        $this->transitionTo(OrderStatus::CANCELLED);
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function customerId(): Uuid  // ← CORRECTO
    {
        return $this->customerId;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function status(): OrderStatus
    {
        return $this->status;
    }

    public function total(): Money
    {
        return $this->total;
    }

    public function items(): array
    {
        return $this->items;
    }

    private function recalculateTotal(): void       
    {
        $total = 0;
        foreach ($this->items as $item) {
            $total += $item->subtotal()->amount;    
        }

        $this->total = new Money($total, Currency::EUR);
    }

    private function transitionTo(OrderStatus $newStatus): void
    {
        if (!$this->status->canTransitionTo($newStatus)) {
            throw new InvalidStateTransitionException(
                "Order can not transition from {$this->status->value} to {$newStatus->value}"
            );
        }
        
        $this->status = $newStatus;
    }
}