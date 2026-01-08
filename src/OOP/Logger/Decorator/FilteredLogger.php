<?php

declare(strict_types=1);

namespace Ejercicios\OOP\Logger\Decorator;

use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;

final readonly class FilteredLogger implements LoggerInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly LogLevel $minLevel = LogLevel::DEBUG
    ) {}

    public function log(LogLevel $level, string $message, array $context = []): void
    {
        if ($level->getWeight() < $this->minLevel->getWeight()) {
            return;
        }

        $this->logger->log($level, $message, $context);
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
