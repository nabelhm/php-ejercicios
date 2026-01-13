<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Infrastructure\Event;

use Ejercicios\MiniProject\Domain\Event\DomainEventInterface;

final class EventDispatcher implements EventDispatcherInterface
{
    /**
     * @var array<string, array<callable>>
     */
    private array $listeners = [];

    public function dispatch(DomainEventInterface $event): void
    {
        $eventName = $event->getName();

        if (!isset($this->listeners[$eventName])) {
            return;
        }

        foreach ($this->listeners[$eventName] as $listener) {
            $listener($event);
        }
    }

    public function addListener(string $eventName, callable $listener): void
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }

        $this->listeners[$eventName][] = $listener;
    }
}