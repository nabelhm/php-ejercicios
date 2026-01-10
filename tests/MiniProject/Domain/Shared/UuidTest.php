<?php

declare(strict_types=1);

namespace Tests\MiniProject\Domain\Shared;

use Ejercicios\MiniProject\Domain\Shared\Uuid;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    public function testConstruct(): void
    {
        $uuid = new Uuid('uuid-1234');

        $this->assertInstanceOf(Uuid::class, $uuid);
    }

    public function testValueMustNotBeEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        new Uuid('');
    }

    public function testGenerateUuid(): void
    {
        $uuid = Uuid::generate();

        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertIsString($uuid->value());
    }

    public function testValue(): void
    {
        $uuid = new Uuid('uuid-1234');

        $this->assertEquals('uuid-1234', $uuid->value());
    }

    public function testFromString(): void
    {
        $uuid = Uuid::fromString('uuid-1234');

        $this->assertInstanceOf(Uuid::class, $uuid);
        $this->assertEquals('uuid-1234', $uuid->value());
    }


    public function testEqualsTrue(): void
    {
        $uuid  = Uuid::fromString('uuid-1234');
        $uuid1 = Uuid::fromString('uuid-1234');

        $this->assertTrue($uuid->equals($uuid1));
    }

    public function testEqualsFalse(): void
    {
        $uuid  = Uuid::fromString('uuid-1234');
        $uuid1 = Uuid::fromString('uuid-1235');

        $this->assertFalse($uuid->equals($uuid1));
    }
}
