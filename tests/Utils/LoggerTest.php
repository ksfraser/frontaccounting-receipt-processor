<?php

namespace Tests\Utils;

use App\Utils\Logger;
use Monolog\Logger as MonologLogger;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testCreateLogger(): void
    {
        $logger = Logger::createLogger();

        $this->assertInstanceOf(MonologLogger::class, $logger);
        $this->assertTrue($logger->getHandlers() !== []);
    }
}
