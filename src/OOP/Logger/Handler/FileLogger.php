<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Logger\Handler;

use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;

class FileLogger implements LoggerInterface
{
    public function __construct(private readonly string $filepath) {}

    public function log(LogLevel $level, string $message, array $context = []): void
    {
        $directory = dirname($this->filepath);

        if (!is_dir($directory)) {
            mkdir($directory, 0777, true);
        }

        $log = "[{$level->value}] $message";
        file_put_contents($this->filepath, $log . PHP_EOL, FILE_APPEND);
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
