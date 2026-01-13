<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Event;

use DateTimeImmutable;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

final readonly class OrderCreated implements DomainEventInterface
{
    public function __construct(
        private Uuid $orderId,
        private Uuid $customerId,
        private DateTimeImmutable $occurredAt
    ) {}

    public function getName(): string
    {
        return 'order.created';
    }

    public function orderId(): Uuid
    {
        return $this->orderId;
    }

    public function customerId(): Uuid
    {
        return $this->customerId;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}