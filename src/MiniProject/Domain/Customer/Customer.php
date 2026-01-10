<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Customer;

use Ejercicios\MiniProject\Domain\Shared\Uuid;

class Customer
{
    public function __construct(private readonly Uuid $id, public string $name) {}

    public static function create(string $name): self
    {
        return new self(Uuid::generate(), $name);
    }

    public function getId(): Uuid       
    {
        return $this->id;
    }
}
