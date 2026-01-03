<?php

namespace Tests\OOP\Events;

use Ejercicios\OOP\Events\EventDispatcher;
use Ejercicios\OOP\Events\EventInterface;
use Ejercicios\OOP\Events\Listener\ListenerInterface;
use Ejercicios\OOP\Events\UserCreatedEvent;
use PHPUnit\Framework\TestCase;

class EventDispatcherTest extends TestCase
{
    private function getListeners(EventDispatcher $dispatcher): array
    {
        $reflection = new \ReflectionClass($dispatcher);
        $property = $reflection->getProperty('listeners');
        return $property->getValue($dispatcher);
    }

    public function testConstructEventDispatcher(): void
    {
        $dispatcher = new EventDispatcher;

        $this->assertInstanceOf(EventDispatcher::class, $dispatcher);
    }

    public function testSubscribeRegistersListener(): void
    {
        $dispatcher = new EventDispatcher();
          $listener = new class implements ListenerInterface {
            public bool $executed = false;
            public function handle(EventInterface $event): void
            {
                $this->executed = true;
            }
        };


        $dispatcher->subscribe('user.created', $listener);

        $listeners = $this->getListeners($dispatcher);
        $this->assertArrayHasKey('user.created', $listeners);
        $this->assertCount(1, $listeners['user.created']);
    }

    public function testDispatchExecutesRegisteredListeners(): void
    {
        $dispatcher = new EventDispatcher();

        $listener = new class implements ListenerInterface {
            public bool $executed = false;
            public function handle(EventInterface $event): void
            {
                $this->executed = true;
            }
        };

        $dispatcher->subscribe('user.created', $listener);
        $dispatcher->dispatch(new UserCreatedEvent('USER_01'));

        $this->assertTrue($listener->executed);
    }

    // TEST: Múltiples listeners se ejecutan
    public function testDispatchExecutesMultipleListeners(): void
    {
        $dispatcher = new EventDispatcher();

        $listener1 = new class implements ListenerInterface {
            public bool $executed = false;
            public function handle(EventInterface $event): void
            {
                $this->executed = true;
            }
        };

        $listener2 = new class implements ListenerInterface {
            public bool $executed = false;
            public function handle(EventInterface $event): void
            {
                $this->executed = true;
            }
        };

        $dispatcher->subscribe('user.created', $listener1);
        $dispatcher->subscribe('user.created', $listener2);
        $dispatcher->dispatch(new UserCreatedEvent('USER_01'));

        $this->assertTrue($listener1->executed);
        $this->assertTrue($listener2->executed);
    }

    // TEST: Orden de ejecución
    public function testListenersExecuteInSubscriptionOrder(): void
    {
        $dispatcher = new EventDispatcher();
        $executionOrder = [];

        $listener1 = new class($executionOrder) implements ListenerInterface {
            public function __construct(private array &$order) {}
            public function handle(EventInterface $event): void
            {
                $this->order[] = 1;
            }
        };

        $listener2 = new class($executionOrder) implements ListenerInterface {
            public function __construct(private array &$order) {}
            public function handle(EventInterface $event): void
            {
                $this->order[] = 2;
            }
        };

        $dispatcher->subscribe('user.created', $listener1);
        $dispatcher->subscribe('user.created', $listener2);
        $dispatcher->dispatch(new UserCreatedEvent('USER_01'));

        $this->assertEquals([1, 2], $executionOrder);
    }

    // TEST: Solo ejecuta listeners del evento correcto
    public function testDispatchOnlyExecutesRelevantListeners(): void
    {
        $dispatcher = new EventDispatcher();

        $userListener = new class implements ListenerInterface {
            public bool $executed = false;
            public function handle(EventInterface $event): void
            {
                $this->executed = true;
            }
        };

        $orderListener = new class implements ListenerInterface {
            public bool $executed = false;
            public function handle(EventInterface $event): void
            {
                $this->executed = true;
            }
        };

        $dispatcher->subscribe('user.created', $userListener);
        $dispatcher->subscribe('order.placed', $orderListener);

        $dispatcher->dispatch(new UserCreatedEvent('USER_01'));

        $this->assertTrue($userListener->executed);
        $this->assertFalse($orderListener->executed);
    }

    // TEST: Dispatch sin listeners no falla
    public function testDispatchWithoutListenersDoesNotThrow(): void
    {
        $dispatcher = new EventDispatcher();

        $this->expectNotToPerformAssertions();
        $dispatcher->dispatch(new UserCreatedEvent('USER_01'));
    }
}
