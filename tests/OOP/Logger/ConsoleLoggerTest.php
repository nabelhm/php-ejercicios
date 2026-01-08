<?php

namespace Tests\OOP\Logger;

use Ejercicios\OOP\Logger\Handler\ConsoleLogger;
use Ejercicios\OOP\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class ConsoleLoggerTest extends TestCase
{

    public function testConstructor(): void
    {
        $logger = new ConsoleLogger();
        $this->assertInstanceOf(ConsoleLogger::class, $logger);
    }

    public function testCreatesLog(): void
    {
        $message  = 'This is a warning log';
        $logger = new ConsoleLogger();

        ob_start();
        $logger->log(
            LogLevel::WARNING,
            $message
        );
        $output = ob_get_clean();

        $this->assertStringContainsString($message, $output);
    }

    public function testDebug(): void
    {
        $message  = 'This is a debug log';

        $logger = new ConsoleLogger();

        ob_start();
        $logger->debug(
            $message
        );
        $output = ob_get_clean();

        $this->assertStringContainsString("[DEBUG] $message", $output);
    }

    public function testInfo(): void
    {
        $message  = 'This is an info log';

        $logger = new ConsoleLogger();

        ob_start();
        $logger->info(
            $message
        );
        $output = ob_get_clean();

        $this->assertStringContainsString("[INFO] $message", $output);
    }

    public function testWarning(): void
    {
        $message  = 'This is a warning log';

       $logger = new ConsoleLogger();

        ob_start();
        $logger->warning(
            $message
        );
        $output = ob_get_clean();

        $this->assertStringContainsString("[WARNING] $message", $output);
    }

    public function testError(): void
    {
        $message  = 'This is an error log';

       $logger = new ConsoleLogger();

        ob_start();
        $logger->error(
            $message
        );
        $output = ob_get_clean();
        
        $this->assertStringContainsString("[ERROR] $message", $output);
    }
}
