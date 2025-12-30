<?php
namespace Ejercicios\OOP\Money;

enum Currency: string
{
    case USD = 'USD';
    case EUR = 'EUR';
    case GBP = 'GBP';
    
    public static function fromString(string $code): self
    {
        return self::from($code);
    }
}