<?php

declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Product;

use Ejercicios\MiniProject\Domain\Money\Currency;
use Ejercicios\MiniProject\Domain\Money\Money;
use Ejercicios\MiniProject\Domain\Shared\Uuid;

use InvalidArgumentException;

class Product
{
    public function __construct(
        private readonly Uuid $id,
        private string $name,
        private Money $price
    ) {
        if (empty($name)) {
            throw new InvalidArgumentException("Name can not be empty");
        }

        if (0 == $price->amount) {
            throw new InvalidArgumentException("Price can not be zero");
        }
    }

    public static function create(string $name, int $priceAmount, ?Currency $currency = Currency::EUR): self
    {
        return new self(
            Uuid::generate(),
            $name,
            new Money($priceAmount, $currency)
        );
    }

    public function id(): Uuid
    {
        return $this->id;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function price(): Money
    {
        return $this->price;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
