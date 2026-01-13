<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Event;

interface DomainEventInterface
{
    public function getName(): string;
}
