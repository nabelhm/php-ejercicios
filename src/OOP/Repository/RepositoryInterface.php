<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Repository;

interface RepositoryInterface
{
    public function find(string $id): ?object;
    public function save(object $entity): void;
    public function delete(string $id): void;
    public function findAll(): array;
}