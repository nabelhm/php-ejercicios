<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Repository;

class InMemoryRepository extends AbstractRepository
{
    private array $entities = [];

    public function find(string $id): ?object
    {
        return $this->entities[$id] ?? null;
    }


    public function save(object $entity): void
    {
        $id = $this->getEntityId($entity);

        if ($id === null) {
            $id = $this->generateId();
            $entity->id = $id;  // ✅ ASIGNAR el ID generado
        }

        $this->entities[$id] = $entity;
    }

    public function delete(string $id): void
    {
        unset($this->entities[$id]);
    }

    public function findAll(): array
    {
        return array_values($this->entities);
    }
}
