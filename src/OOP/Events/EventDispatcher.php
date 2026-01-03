<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Events;

use Ejercicios\OOP\Events\Listener\ListenerInterface;

class EventDispatcher
{
    /** @var array<string, ListenerInterface[]> */
    private array $listeners = [];

    public function subscribe(string $eventName, ListenerInterface $listener): void
    {
        if (!isset($this->listeners[$eventName])) {
            $this->listeners[$eventName] = [];
        }
        
        $this->listeners[$eventName][] = $listener;
    }

    public function dispatch(EventInterface $event): void
    {
        $eventName = $event->getName();
        
        if (!isset($this->listeners[$eventName])) {
            return;
        }
        
        foreach ($this->listeners[$eventName] as $listener) {
            $listener->handle($event);
        }
    }
}