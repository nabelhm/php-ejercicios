<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Events\Listener;

use Ejercicios\OOP\Events\EventInterface;

interface ListenerInterface
{
    public function handle(EventInterface $event): void;
}
