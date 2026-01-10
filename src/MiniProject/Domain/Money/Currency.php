<?php
declare(strict_types=1);

namespace Ejercicios\MiniProject\Domain\Money;

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