<?php
declare(strict_types=1);

namespace Tests\OOP\Logger;

use Ejercicios\OOP\Logger\Decorator\FilteredLogger;
use Ejercicios\OOP\Logger\Decorator\TimestampedLogger;
use Ejercicios\OOP\Logger\Handler\ConsoleLogger;
use Ejercicios\OOP\Logger\Handler\FileLogger;
use Ejercicios\OOP\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class LoggerDecoratedIntegrationTest extends TestCase
{
    public function testConsoleLoggerSeveralDecorators(): void
    {
        $baseLogger = new ConsoleLogger();

        ob_start();
        $timestamped = new TimestampedLogger($baseLogger);
        $filtered = new FilteredLogger($timestamped, minLevel: LogLevel::WARNING);

        $filtered->debug('This is a debug log');
        $filtered->warning('This is a warning log');

        $output = ob_get_clean();

        $this->assertStringContainsString('This is a warning log', $output);
        $this->assertMatchesRegularExpression('/^\[WARNING\] \[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] This is a warning log\n$/', $output);
        $this->assertStringNotContainsString("[DEBUG] This is a debug log", $output);

    }

    public function tesFileLoggerSeveralDecorators(): void
    {

        $baseLogger = new FileLogger('logs');

        $timestamped = new TimestampedLogger($baseLogger);
        $filtered = new FilteredLogger($timestamped, minLevel: LogLevel::WARNING);

        $filtered->debug('This is a debug log');
        $filtered->warning('This is a warning log');

        $fileLogs = file_get_contents("logs/logs.txt");
        $this->assertStringContainsString("[WARNING] This is a warning log", $fileLogs);
        $this->assertMatchesRegularExpression('/^\[WARNING\] \[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\] This is a warning log\n$/', $fileLogs);

        $this->assertStringNotContainsString("[DEBUG] This is a debug log", $fileLogs);
    }
}