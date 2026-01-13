<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Event;

use DateTimeImmutable;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

final readonly class OrderConfirmed implements DomainEventInterface
{
    public function __construct(
        private Uuid $orderId,
        private DateTimeImmutable $occurredAt
    ) {}

    public function getName(): string
    {
        return 'order.confirmed';
    }

    public function orderId(): Uuid
    {
        return $this->orderId;
    }

    public function occurredAt(): DateTimeImmutable
    {
        return $this->occurredAt;
    }
}