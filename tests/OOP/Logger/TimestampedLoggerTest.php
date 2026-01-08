<?php

declare(strict_types=1);

namespace Tests\OOP\Logger;

use Ejercicios\OOP\Logger\Decorator\TimestampedLogger;
use Ejercicios\OOP\Logger\Handler\NullLogger;
use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class TimestampedLoggerTest extends TestCase
{
    public function testConstruct(): void
    {
        $timestampedLogger = new TimestampedLogger(new NullLogger());

        $this->assertInstanceOf(TimestampedLogger::class, $timestampedLogger);
    }

    public function testAddsTimestampToMessage(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::WARNING),
                $this->matchesRegularExpression('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test$/'),
                $this->identicalTo([])
            );

        $timestamped = new TimestampedLogger($mockLogger);
        $timestamped->log(LogLevel::WARNING, 'test');
    }
    
    public function testSendContextUntouch(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::WARNING),
                $this->matchesRegularExpression('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test$/'),
                $this->identicalTo(['context' => 'text Context'])
            );

        $timestamped = new TimestampedLogger($mockLogger);
        $timestamped->log(LogLevel::WARNING, 'test', ['context' => 'text Context']);
    }

    public function testDebugSendLogLevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::DEBUG),
                $this->matchesRegularExpression('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test$/'),
                $this->identicalTo([])
            );

        $timestamped = new TimestampedLogger($mockLogger);
        $timestamped->debug('test');
    }

    public function testInfoSendLogLevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::INFO),
                $this->matchesRegularExpression('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test$/'),
                $this->identicalTo([])
            );

        $timestamped = new TimestampedLogger($mockLogger);
        $timestamped->info('test');
    }

    public function testWarningSendLogLevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::WARNING),
                $this->matchesRegularExpression('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test$/'),
                $this->identicalTo([])
            );

        $timestamped = new TimestampedLogger($mockLogger);
        $timestamped->warning('test');
    }

    public function testErrorSendLogLevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::ERROR),
                $this->matchesRegularExpression('/^\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] test$/'),
                $this->identicalTo([])
            );

        $timestamped = new TimestampedLogger($mockLogger);
        $timestamped->error('test');
    }
}
