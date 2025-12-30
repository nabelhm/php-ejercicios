<?php

namespace Ejercicios\OOP\Money;

use Exception;
use InvalidArgumentException;

class Money
{
    public function __construct(
        readonly private int $amount, //in cents
        readonly private Currency $currency)
    {
    }

    public function getAmount(): int    
    {
        return $this->amount;
    }

    public function getCurrency(): Currency    
    {
        return $this->currency;
    }

    public function add(int $amount): self
    {
        return new Money(
            $this->amount + $amount,
            $this->currency
        );
    }

    public function subtract(int $amount): self
    {
        if ($amount > $this->amount) throw new InvalidArgumentException("negative_amount");
        
        return new Money(
            $this->amount - $amount,
            $this->currency
        );
    }

    public function multiply(float $times): self
    {
        return new Money(
            $this->amount * $times,
            $this->currency
        );
    
    }

    public function divide(float $times): self
    {
        if ($times == 0) throw new InvalidArgumentException("division_by_zero");

        return new Money(
            $this->amount / $times,
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
        if ($money->currency !== $this->currency) throw new Exception("invalid_currency");
        
        return (
            $money->amount === $this->amount 
        );
    }

    public function greaterThan(self $money): bool
    {
        if ($money->currency !== $this->currency) throw new Exception("invalid_currency");
        
        return (
            $this->amount >= $money->amount
        );
    }

    public function lessThan(self $money): bool
    {
        if ($money->currency !== $this->currency) throw new Exception("invalid_currency");
        
        return (
            $this->amount <= $money->amount 
        );
    }
}