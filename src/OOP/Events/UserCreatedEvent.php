<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Events;

class UserCreatedEvent implements EventInterface
{

    public function __construct(public string $user) {}

    public function getName(): string
    {
        return 'user.created';
    }
}
