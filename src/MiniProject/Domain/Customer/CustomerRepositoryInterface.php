<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Customer;

use Ejercicios\MiniProject\Domain\Shared\Uuid;

interface CustomerRepositoryInterface
{
    public function find(Uuid  $uuid): ?Customer;
    public function save(Customer $customer): void;
    public function findAll(): array;
}
