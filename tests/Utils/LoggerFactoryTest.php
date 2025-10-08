<?php

namespace Tests\Utils;

use App\Utils\LoggerFactory;
use Monolog\Logger;
use PHPUnit\Framework\TestCase;
use PDO;
use PDOStatement;

class LoggerFactoryTest extends TestCase
{
    private string $logFile;
    private PDO $pdo;

    protected function setUp(): void
    {
        $this->logFile = __DIR__ . '/test.log';
        $this->pdo = $this->createMock(PDO::class);
    }

    protected function tearDown(): void
    {
        if (file_exists($this->logFile)) {
            unlink($this->logFile);
        }
    }

    public function testCreateLoggerWithFileHandler(): void
    {
        $factory = new LoggerFactory($this->logFile);
        $logger = $factory->createLogger('test_channel', 'file');

        $this->assertInstanceOf(Logger::class, $logger);

        $logger->info('Test log message');

        // Ensure the log file is created after logging
        $this->assertFileExists($this->logFile);
        $this->assertStringContainsString('Test log message', file_get_contents($this->logFile));
    }

    public function testCreateLoggerWithDatabaseHandler(): void
    {
        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())->method('execute');

        $this->pdo->expects($this->once())->method('prepare')->willReturn($stmt);

        $factory = new LoggerFactory($this->logFile, $this->pdo);
        $logger = $factory->createLogger('test_channel', 'database');

        $this->assertInstanceOf(Logger::class, $logger);

        $logger->info('Test log message');
    }

    public function testGetLogsFromDatabase(): void
    {
        $expectedLogs = [
            ['message' => 'Test log message', 'created_at' => '2025-10-07 12:00:00']
        ];

        $stmt = $this->createMock(PDOStatement::class);
        $stmt->expects($this->once())->method('fetchAll')->willReturn($expectedLogs);

        $this->pdo->expects($this->once())->method('query')->willReturn($stmt);

        $factory = new LoggerFactory($this->logFile, $this->pdo);
        $logs = $factory->getLogsFromDatabase();

        $this->assertEquals($expectedLogs, $logs);
    }
}
