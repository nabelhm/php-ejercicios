<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Repository;

use DateTimeImmutable;

trait Timestampable
{
    public DateTimeImmutable $createdAt;
    public DateTimeImmutable $updatedAt;

    public function initializeTimestamps(): void
    {
        $now = new DateTimeImmutable();
        $this->createdAt = $now;
        $this->updatedAt = $now;
    }

    public function updateTimestamp(): void
    {
        $this->updatedAt = new DateTimeImmutable();
    }
}
