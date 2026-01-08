<?php

namespace Tests\OOP\Logger;

use Ejercicios\OOP\Logger\Handler\FileLogger;
use Ejercicios\OOP\Logger\LogLevel;
use PHPUnit\Framework\TestCase;

class FileLoggerTest extends TestCase
{
    private string $filePath = 'logs';

    private string $fileName = "logs.txt";

    protected function setUp(): void
    {
        parent::setUp();
        $this->filePath = sys_get_temp_dir() . '/test_logs_' . uniqid();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        // Eliminar archivo si existe
        $logFile = $this->filePath . '/logs.txt';
        if (file_exists($logFile)) {
            unlink($logFile);
        }

        // Eliminar directorio si existe
        if (is_dir($this->filePath)) {
            rmdir($this->filePath);
        }
    }

    public function testConstructor(): void
    {
        $logger = new FileLogger('/logs');
        $this->assertInstanceOf(FileLogger::class, $logger);
    }

    public function testLogCreatesLogFile(): void
    {
        $message = 'This is a warning log';

        $logger = new FileLogger($this->filePath . '/logs.txt'); // ← Path completo
        $logger->log(LogLevel::WARNING, $message);

        $this->assertFileExists($this->filePath . '/logs.txt');
    }

    public function testDebug(): void
    {
        $message  = 'This is a debug log';

        $logger = new FileLogger($this->filePath . '/logs.txt');
        $logger->debug(
            $message
        );

        $fileLogs = file_get_contents("$this->filePath/logs.txt");
        $this->assertStringContainsString("[DEBUG] $message", $fileLogs);
    }

    public function testInfo(): void
    {
        $message  = 'This is an info log';

        $logger = new FileLogger($this->filePath . '/logs.txt');
        $logger->info(
            $message
        );

        $fileLogs = file_get_contents("$this->filePath/$this->fileName");
        $this->assertStringContainsString("[INFO] $message", $fileLogs);
    }

    public function testWarning(): void
    {
        $message  = 'This is a warning log';

        $logger = new FileLogger($this->filePath . '/logs.txt');
        $logger->warning(
            $message
        );

        $fileLogs = file_get_contents("$this->filePath/$this->fileName");
        $this->assertStringContainsString("[WARNING] $message", $fileLogs);
    }

    public function testError(): void
    {
        $message  = 'This is an error log';

        $logger = new FileLogger($this->filePath . '/logs.txt');
        $logger->error(
            $message
        );

        $fileLogs = file_get_contents("$this->filePath/$this->fileName");
        $this->assertStringContainsString("[ERROR] $message", $fileLogs);
    }
}
