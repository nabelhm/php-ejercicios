<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Logger\Handler;

use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;

class ConsoleLogger implements LoggerInterface
{
    public function log(LogLevel $level, string $message, array $context = []): void
    {
        echo "[{$level->value}] $message" . PHP_EOL;
    }

    public function debug(string $message, array $context = []): void
    {
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function info(string $message, array $context = []): void
    {
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function warning(string $message, array $context = []): void
    {
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function error(string $message, array $context = []): void
    {
        $this->log(LogLevel::ERROR, $message, $context);
    }
}
