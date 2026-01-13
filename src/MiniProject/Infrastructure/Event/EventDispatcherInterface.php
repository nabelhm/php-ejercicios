<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Infrastructure\Event;

use Ejercicios\MiniProject\Domain\Event\DomainEventInterface;

interface EventDispatcherInterface
{
    public function dispatch(DomainEventInterface $event): void;
    public function addListener(string $eventName, callable $listener): void;
}