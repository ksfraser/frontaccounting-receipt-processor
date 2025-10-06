<?php

namespace App\Utils;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Formatter\LineFormatter;

/**
 * Class Logger
 *
 * Provides logging functionality using Monolog.
 *
 * UML Diagram:
 * ```plantuml
 * @startuml
 * class Logger {
 *     + static createLogger(): Monolog\Logger
 * }
 * @enduml
 * ```
 */
class Logger
{
    public static function createLogger(): MonologLogger
    {
        $logger = new MonologLogger('application');

        $consoleHandler = new ErrorLogHandler(ErrorLogHandler::OPERATING_SYSTEM, MonologLogger::DEBUG);
        $fileHandler = new StreamHandler(__DIR__ . '/../../logs/application.log', MonologLogger::DEBUG);

        $formatter = new LineFormatter(null, null, true, true);
        $consoleHandler->setFormatter($formatter);
        $fileHandler->setFormatter($formatter);

        $logger->pushHandler($consoleHandler);
        $logger->pushHandler($fileHandler);

        return $logger;
    }
}
