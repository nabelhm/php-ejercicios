<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Customer;

use Ejercicios\MiniProject\Domain\Shared\Uuid;

class Customer
{
    public function __construct(
        private Uuid $id,
        private string $name
    ) {}

    public static function create(string $name): self
    {
        return new self(Uuid::generate(), $name);
    }

    public function id(): Uuid
    {
        return $this->id;
    }
    
    public function name(): string
    {
        return $this->name;
    }

    public function setName(string $newName): void
    {
        $this->name = $newName;
    }
}
