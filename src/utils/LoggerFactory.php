<?php

namespace App\Utils;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;
use PDO;

class LoggerFactory
{
    private string $defaultLogFile;
    private ?PDO $pdo;

    public function __construct(string $defaultLogFile, ?PDO $pdo = null)
    {
        $this->defaultLogFile = $defaultLogFile;
        $this->pdo = $pdo;
    }

    public function createLogger(string $channel, string $handlerType = 'file'): Logger
    {
        $logger = new Logger($channel);

        switch ($handlerType) {
            case 'file':
                $handler = new StreamHandler($this->defaultLogFile, Logger::DEBUG);
                break;

            case 'database':
                if ($this->pdo === null) {
                    throw new \InvalidArgumentException('PDO instance is required for database logging.');
                }
                $handler = $this->createDatabaseHandler();
                break;

            default:
                throw new \InvalidArgumentException("Unsupported handler type: $handlerType");
        }

        $formatter = new LineFormatter(null, null, true, true);
        $handler->setFormatter($formatter);

        $logger->pushHandler($handler);

        return $logger;
    }

    private function createDatabaseHandler(): StreamHandler
    {
        return new class($this->pdo) extends StreamHandler {
            private PDO $pdo;

            public function __construct(PDO $pdo)
            {
                parent::__construct('php://memory', Logger::DEBUG);
                $this->pdo = $pdo;
            }

            protected function write(array $record): void
            {
                $stmt = $this->pdo->prepare('INSERT INTO logs (channel, level, message, context, created_at) VALUES (:channel, :level, :message, :context, :created_at)');
                $stmt->execute([
                    'channel' => $record['channel'],
                    'level' => $record['level_name'],
                    'message' => $record['message'],
                    'context' => json_encode($record['context']),
                    'created_at' => $record['datetime']->format('Y-m-d H:i:s'),
                ]);
            }
        };
    }

    public function getLogsFromDatabase(): array
    {
        if ($this->pdo === null) {
            throw new \RuntimeException('PDO instance is required to fetch logs from the database.');
        }

        $stmt = $this->pdo->query('SELECT * FROM logs ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
