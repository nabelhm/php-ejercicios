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

    public static function fromString(string $level): self {
        foreach (LogLevel::cases() as $case) {
            if ($case->value === $level) {
                return $case;
            }
        }
        throw new InvalidArgumentException("$level do not corresponds to LogLevel case");
    }

    public function getWeight(): int
    {
        return match($this) {
            self::DEBUG => 1,
            self::INFO => 2,
            self::WARNING => 3,
            self::ERROR => 4,
        };
    }
}
