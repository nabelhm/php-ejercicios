<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Product;

use Ejercicios\MiniProject\Domain\Shared\Uuid;

interface ProductRepositoryInterface
{
    public function find(Uuid  $uuid): ?Product;
    public function save(Product $product): void;
    public function findAll(): array;
}
