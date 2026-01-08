<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Logger;

use InvalidArgumentException;

enum LogLevel: string
{
    case DEBUG = 'DEBUG';
    case INFO = 'INFO';
    case WARNING = 'WARNING';
    case ERROR = 'ERROR';

    public static function fromString(string $level): self
    {
        $normalized = strtoupper($level);

        return match ($normalized) {
            'DEBUG' => self::DEBUG,
            'INFO' => self::INFO,
            'WARNING' => self::WARNING,
            'ERROR' => self::ERROR,
            default => throw new InvalidArgumentException("Invalid log level: $level"),
        };
    }

    public function getWeight(): int
    {
        return match ($this) {
            self::DEBUG => 1,
            self::INFO => 2,
            self::WARNING => 3,
            self::ERROR => 4,
        };
    }
}
