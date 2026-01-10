<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Money;

use InvalidArgumentException;

class Money
{
    public function __construct(
        readonly public int $amount, //in cents
        readonly public Currency $currency
    ) {
        if ($amount < 0) throw new InvalidArgumentException("Amount must be greater than or equal to zero");
    }

    public function add(self $money): self
    {
        if ($money->currency !== $this->currency) throw new InvalidArgumentException("Invalid currency. Operations must have the same currency");

        return new Money(
            $this->amount + $money->amount,
            $this->currency
        );
    }

    public function subtract(self $money): self
    {
        if ($money->currency !== $this->currency) throw new InvalidArgumentException("Invalid currency. Operations must have the same currency");
        if ($money->amount > $this->amount) throw new InvalidArgumentException("Invalid amount. Subtractor must be less than original");

        return new Money(
            $this->amount - $money->amount,
            $this->currency
        );
    }

    public function multiply(float $times): self 
    {
        return new Money(
            (int) round($this->amount * $times),
            $this->currency
        );
    }

    public function divide(float $times): self
    {
        if ($times === 0.0) throw new InvalidArgumentException("Cannot divide by zero");

        return new Money(
            (int) round($this->amount / $times),
            $this->currency
        );
    }

    public function __toString(): string
    {
        $amountText = number_format($this->amount / 100, 2);
        $currencyText = $this->currency->name;

        return "$amountText $currencyText";
    }

    public function equals(self $money): bool
    {
        if ($money->currency !== $this->currency) throw new InvalidArgumentException("Invalid currency. Operations must have the same currency");

        return (
            $money->amount === $this->amount
        );
    }

    public function greaterThan(self $money): bool
    {
        if ($money->currency !== $this->currency) throw new InvalidArgumentException("Invalid currency. Operations must have the same currency");

        return (
            $this->amount > $money->amount
        );
    }

    public function lessThan(self $money): bool
    {
        if ($money->currency !== $this->currency) throw new InvalidArgumentException("Invalid currency. Operations must have the same currency");

        return (
            $this->amount < $money->amount
        );
    }

    public static function fromString(string $moneyText): self
    {
        $parts = explode(' ', $moneyText);

        if (count($parts) !== 2) {
            throw new InvalidArgumentException("Invalid format. Expected: '100.50 EUR'");
        }

        [$amount, $currency] = $parts;

        return new Money(
            (int) round((float) $amount * 100),
            Currency::fromString($currency)
        );
    }
}
