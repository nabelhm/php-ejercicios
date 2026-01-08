<?php

declare(strict_types=1);

namespace Tests\OOP\Logger;

use Ejercicios\OOP\Logger\Decorator\FilteredLogger;
use Ejercicios\OOP\Logger\Handler\NullLogger;
use Ejercicios\OOP\Logger\LoggerInterface;
use Ejercicios\OOP\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class FilteredLoggerTest extends TestCase
{
    public function testConstruct(): void
    {
        $filteredLogger = new FilteredLogger(
            new NullLogger(),
            LogLevel::WARNING
        );

        $this->assertInstanceOf(FilteredLogger::class, $filteredLogger);
    }

    public function testSendMessageAndContextUntouch(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::ERROR),
                $this->identicalTo('test'),
                $this->identicalTo(['context' => 'text Context'])
            );

        $filteredLogger = new FilteredLogger(
            $mockLogger
        );
        $filteredLogger->log(LogLevel::ERROR, 'test', ['context' => 'text Context']);
    }

    public function testAllowsLogsHigherThanlevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::ERROR),
                $this->identicalTo('test'),
                $this->identicalTo([])
            );

        $filteredLogger = new FilteredLogger(
            $mockLogger,
            LogLevel::WARNING
        );
        $filteredLogger->log(LogLevel::ERROR, 'test', []);
    }

    public function testFilterLogsLowerThanlevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->never())
            ->method('log')
        ;

        $filteredLogger = new FilteredLogger(
            $mockLogger,
            LogLevel::WARNING
        );
        $filteredLogger->log(LogLevel::INFO, 'test', []);
    }

    public function testDebugSendLogLevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::DEBUG),
                $this->identicalTo('test'),
                $this->identicalTo([])
            );

        $filteredLogger = new FilteredLogger(
            $mockLogger
        );
        $filteredLogger->debug('test', []);
    }

    public function testInfoSendLogLevel(): void
    {
       $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::INFO),
                $this->identicalTo('test'),
                $this->identicalTo([])
            );

        $filteredLogger = new FilteredLogger(
            $mockLogger
        );
        $filteredLogger->info('test', []);
    }

    public function testWarningSendLogLevel(): void
    {
        $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::WARNING),
                $this->identicalTo('test'),
                $this->identicalTo([])
            );

        $filteredLogger = new FilteredLogger(
            $mockLogger
        );
        $filteredLogger->warning('test', []);
    }

    public function testErrorSendLogLevel(): void
    {
       $mockLogger = $this->createMock(LoggerInterface::class);
        $mockLogger
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->identicalTo(LogLevel::ERROR),
                $this->identicalTo('test'),
                $this->identicalTo([])
            );

        $filteredLogger = new FilteredLogger(
            $mockLogger
        );
        $filteredLogger->error('test', []);
    }
}
