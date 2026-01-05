<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Repository;

class CachedRepository implements RepositoryInterface
{
    private array $cache = [];

    public function __construct(private RepositoryInterface $repository, private ?int $ttl = 60) {}

    public function find(string $id): ?object
    {
        if (null !== $this->findInCache($id)) return $this->findInCache($id);

        $found = $this->repository->find($id);
        if (null !== $found) {
            $this->cache[$id] = ['data' => $found, 'expires' => time() + $this->ttl];
        }

        return $found;
    }

    public function save(object $entity): void
    {
        $this->repository->save($entity);
        $this->cache[$entity->id] = ['data' => $entity, 'expires' => time() + $this->ttl];
    }

    public function delete(string $id): void
    {
        unset($this->cache[$id]);
        $this->repository->delete($id);
    }

    public function findAll(): array
    {
        return $this->repository->findAll();
    }


    private function findInCache(string $id): ?object
    {
        if (isset($this->cache[$id]) && time() < $this->cache[$id]['expires']) {
            return $this->cache[$id]['data'];
        }
        return null;
    }
}
