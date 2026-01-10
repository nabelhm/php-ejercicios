<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Shared;

use InvalidArgumentException;

final readonly class Uuid
{
    public function __construct(private readonly string $value)
    {
        if (empty($value)) {
            throw new InvalidArgumentException('UUID cannot be empty');
        }
    }

    public static function generate(): self
    {
        return new self(sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0x0fff) | 0x4000,
            random_int(0, 0x3fff) | 0x8000,
            random_int(0, 0xffff),
            random_int(0, 0xffff),
            random_int(0, 0xffff)
        ));
    }

    public function value(): string
    {
        return $this->value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function equals(self $uuid): bool
    {
        return $this->value === $uuid->value;
    }
}
