<?php
declare(strict_types=1);

namespace Ejercicios\OOP\Logger\Decorator;

use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;
use Exception;

class FilteredLogger implements LoggerInterface
{
    private int $minLevelWeight;
    
    public function __construct(
        private LoggerInterface $logger,
        private LogLevel $minLevel = LogLevel::DEBUG
    ) {
        $this->minLevelWeight = $minLevel->getWeight();
    }

    public function log(LogLevel $level, string $message, array $context = []): void {
        if (!$this->checkLevelWeight($level)) {
            return;
        }

        $this->logger->log($level, $message, $context);
    }

    public function debug(string $message, array $context = []): void{
        $this->log(LogLevel::DEBUG, $message, $context);
    }

    public function info(string $message, array $context = []): void{
        $this->log(LogLevel::INFO, $message, $context);
    }

    public function warning(string $message, array $context = []): void{
        $this->log(LogLevel::WARNING, $message, $context);
    }

    public function error(string $message, array $context = []): void{
        $this->log(LogLevel::ERROR, $message, $context);
    }

    private function checkLevelWeight(LogLevel $level): bool
    {
        return ($level->getWeight() >= $this->minLevelWeight);
    }
}