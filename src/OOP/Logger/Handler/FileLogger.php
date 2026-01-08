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
        if (!is_dir($this->filepath)) {
            mkdir($this->filepath, 0777, true);
        }

        $file = $this->filepath . '/logs.txt';


        $log = "[$level->value] $message ";
        file_put_contents($file, $log . PHP_EOL, FILE_APPEND);
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
