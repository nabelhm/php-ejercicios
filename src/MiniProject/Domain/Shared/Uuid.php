<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Shared;

use InvalidArgumentException;

final readonly class Uuid
{
    public function __construct(private readonly string $value) {
        if (empty($value)) {
            throw new InvalidArgumentException('UUID cannot be empty');
        }
    }

    public static function generate(): self
    {
        return new self(uniqid());
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function equals(self $uuid) : bool {
        return $this->value === $uuid->value;
    }
}
