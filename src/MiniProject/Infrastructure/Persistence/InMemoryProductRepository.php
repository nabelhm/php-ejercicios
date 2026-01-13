<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Infrastructure\Persistence;

use Ejercicios\MiniProject\Domain\Product\Product;
use Ejercicios\MiniProject\Domain\Product\ProductRepositoryInterface;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

class InMemoryProductRepository implements ProductRepositoryInterface
{
    /**
     * @var array<string, Product>
     */
    private array $products = [];

    public function find(Uuid  $id): ?Product
    {
        return $this->products[$id->value()] ?? null;
    }

    public function save(Product $product): void
    {
        $this->products[$product->id()->value()] = $product;
    }

    public function findAll(): array
    {
        return array_values($this->products);
    }
}
