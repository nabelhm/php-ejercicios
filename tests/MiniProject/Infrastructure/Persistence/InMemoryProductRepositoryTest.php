<?php

declare(strict_types=1);

namespace Tests\MiniProject\Infrastructure\Persistence;

use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Shared\Uuid;
use Ejercicios\MiniProject\Infrastructure\Persistence\InMemoryProductRepository;
use PHPUnit\Framework\TestCase;

class InMemoryProductRepositoryTest extends TestCase
{
    public function testSavesAndFindProduct(): void
    {
        $product = new Product(
            id: Uuid::fromString('Prod_01'),
            name: 'table',
            price: new Money(1000, Currency::EUR)
        );

        $repository = new InMemoryProductRepository();
        $repository->save($product);

        $found = $repository->find(Uuid::fromString('Prod_01'));

        $this->assertEquals($product, $found);
    }

    public function testUpdatesProduct(): void
    {
        $product = new Product(
            id: new Uuid('Prod_01'),
            name: 'table',
            price: new Money(1000, Currency::EUR)
        );

        $repository = new InMemoryProductRepository();
        $repository->save($product);
        
        $product->setName('Edited table');
        $repository->save($product);

        $found = $repository->find(Uuid::fromString('Prod_01'));

        $this->assertEquals('Edited table', $found->name());
    }

    public function testReturNullOnNonExistentProduct(): void
    {
        $product = new Product(
            id: new Uuid('Prod_01'),
            name: 'table',
            price: new Money(1000, Currency::EUR)
        );

        $repository = new InMemoryProductRepository();
        $repository->save($product);
        
        $found = $repository->find(Uuid::fromString('Prod_02'));

        $this->assertNull($found);
    }

    public function testFindAllWithProducts(): void
    {
       $product = new Product(
            id: new Uuid('Prod_01'),
            name: 'table',
            price: new Money(1000, Currency::EUR)
        );

       $product2 = new Product(
            id: new Uuid('Prod_02'),
            name: 'adjustable table',
            price: new Money(3000, Currency::EUR)
        );

        $repository = new InMemoryProductRepository();
        $repository->save($product);
        $repository->save($product2);

        $found = $repository->findAll();

        $this->assertCount(2, $found);
        $this->assertContains($product, $found);
        $this->assertContains($product2, $found);
    }

    public function testFindAllReturnEmptyWithNoProducts(): void
    {
        $repository = new InMemoryProductRepository();
        $found = $repository->findAll();

        $this->assertEmpty($found);
    }
}
