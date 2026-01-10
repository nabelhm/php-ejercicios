<?php

declare(strict_types=1);

use Ejercicios\MiniProject\Domain\Customer\Customer;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    public function testConstruct(): void
    {
        $customer = new Customer(
            new Uuid('CUST_1234'),
            'Jonh Doe'
        );

        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testGenerate(): void
    {
        $customer = Customer::create('Jane Doe');

        $this->assertInstanceOf(Customer::class, $customer);
    }

    public function testGetId(): void
    {
        $customer = new Customer(
            new Uuid('CUST_1234'),
            'Jonh Doe'
        );

        $this->assertEquals('CUST_1234', $customer->getId()->value());
    }
}
