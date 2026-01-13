<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Infrastructure\Persistence;

use Ejercicios\MiniProject\Domain\Customer\Customer;
use Ejercicios\MiniProject\Domain\Customer\CustomerRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

final class InMemoryCustomerRepository implements CustomerRepositoryInterface
{
    /**
     * @var array<string, Customer>
     */
    private array $customers = [];

    public function find(Uuid $id): ?Customer
    {
        return $this->customers[$id->value()] ?? null;
    }

    public function save(Customer $customer): void
    {
        $this->customers[$customer->id()->value()] = $customer;
    }

    public function findAll(): array
    {
        return array_values($this->customers);
    }
}