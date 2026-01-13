<?php

declare(strict_types=1);

namespace Tests\MiniProject\Infrastructure\Persistence;

use Ejercicios\MiniProject\Domain\Customer\Customer;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Infrastructure\Persistence\InMemoryCustomerRepository;
use PHPUnit\Framework\TestCase;

class InMemoryCustomerRepositoryTest extends TestCase
{
    public function testSavesAndFindCustomer(): void
    {
        $customer = new Customer(
            Uuid::fromString('user_1'),
            'John Doe'
        );

        $repository = new InMemoryCustomerRepository();
        $repository->save($customer);

        $found = $repository->find(Uuid::fromString('user_1'));
        $this->assertEquals($customer, $found);
    }

    public function testUpdatesCustomer(): void
    {
        $customer = new Customer(
            Uuid::fromString('user_1'),
            'John Doe'
        );
        
        $repository = new InMemoryCustomerRepository();
        $repository->save($customer);
        
        $customer->setName('John Smith'); 
        $repository->save($customer);

        $found = $repository->find(Uuid::fromString('user_1'));
        $this->assertEquals('John Smith', $found->name());
    }

    public function testReturNullOnNonExistentCustomer(): void
    {
        $customer = new Customer(
            Uuid::fromString('user_1'),
            'John Doe'
        );
        
        $repository = new InMemoryCustomerRepository();
        $repository->save($customer);

        $found = $repository->find(Uuid::generate('user_2'));

        $this->assertNull($found);
    }

    public function testFindAllWithCustomers(): void
    {
        $customer = new Customer(
            Uuid::fromString('user_1'),
            'John Doe'
        );

        $customer2 = new Customer(
            Uuid::fromString('user_2'),
            'Jane Hopper'
        );
        
        $repository = new InMemoryCustomerRepository();
        $repository->save($customer);
        $repository->save($customer2);

        $found = $repository->findAll();

        $this->assertEquals(2, count($found));
        $this->assertContains($customer, $found);
        $this->assertContains($customer2, $found);
    }

    public function testFindAllReturnEmptyWithNoCustomers(): void
    {
        $repository = new InMemoryCustomerRepository();
        $found = $repository->findAll();

        $this->assertEmpty($found);
    }
}
