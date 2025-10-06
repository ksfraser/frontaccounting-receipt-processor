<?php

namespace App\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Class LoggerFactory
 *
 * Provides logging functionality using Monolog.
 *
 * UML Diagram:
 * ```plantuml
 * @startuml
 * class LoggerFactory {
 *     + static createLogger(): Monolog\Logger
 * }
 * @enduml
 * ```
 */
class LoggerFactory
{
    public static function createLogger(): Logger
    {
        $logger = new Logger('application');

        $consoleHandler = new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, Logger::DEBUG);
        $fileHandler = new StreamHandler(__DIR__ . '/../../logs/application.log', Logger::DEBUG);

        $formatter = new LineFormatter(null, null, true, true);
        $consoleHandler->setFormatter($formatter);
        $fileHandler->setFormatter($formatter);

        $logger->pushHandler($consoleHandler);
        $logger->pushHandler($fileHandler);

        return $logger;
    }
}
