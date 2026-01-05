<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Repository;

abstract class AbstractRepository implements RepositoryInterface
{

    protected function generateId(): string
    {
        return uniqid('entity_');
    }
    
    protected function getEntityId(object $entity): ?string
    {
        if (isset($entity->id)) {
            return $entity->id;
        }
        return null;
    }

    abstract public function find(string $id): ?object;
    abstract public function save(object $entity): void;
    abstract public function delete(string $id): void;
    abstract public function findAll(): array;
}