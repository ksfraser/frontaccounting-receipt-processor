<?php

namespace Tests\Utils;

use App\Utils\LoggerFactory;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;
use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testCreateLogger(): void
    {
        $logger = LoggerFactory::createLogger();

        $this->assertInstanceOf(MonologLogger::class, $logger);

        $handlers = $logger->getHandlers();
        $this->assertCount(2, $handlers);

        $handlerClasses = array_map(fn($handler) => get_class($handler), $handlers);
        $this->assertContains(ErrorLogHandler::class, $handlerClasses);
        $this->assertContains(StreamHandler::class, $handlerClasses);

        $this->assertEquals('application', $logger->getName());
    }
}
