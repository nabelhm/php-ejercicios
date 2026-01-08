<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Logger\Decorator;

use DateTimeImmutable;
use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;

final readonly class TimestampedLogger implements LoggerInterface
{
    public function __construct(
        private readonly LoggerInterface $logger
    ) {}

    public function log(LogLevel $level, string $message, array $context = []): void
    {
        $timestamped = $this->addTimestamp($message);
        $this->logger->log($level, $timestamped, $context);
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

    private function addTimestamp(string $message): string
    {
        $timestamp = (new DateTimeImmutable())->format('Y-m-d H:i:s');
        return sprintf('[%s] %s', $timestamp, $message);
    }
}
