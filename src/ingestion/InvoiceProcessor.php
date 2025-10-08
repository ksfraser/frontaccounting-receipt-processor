<?php

namespace App\Ingestion;

use App\Integrations\FrontAccounting\FaClient;
use Psr\Log\LoggerInterface;

class InvoiceProcessor
{
    private FaClient $faClient;
    private LoggerInterface $logger;

    public function __construct(FaClient $faClient, LoggerInterface $logger)
    {
        $this->faClient = $faClient;
        $this->logger = $logger;
    }

    public function createInvoice(array $invoicePayload): array
    {
        return $this->faClient->createInvoice($invoicePayload);
    }

    public function attachFileToInvoice(?string $invoiceId, string $filePath): ?array
    {
        if ($invoiceId === null) {
            return null;
        }

        try {
            return $this->faClient->attachFileToInvoice($invoiceId, $filePath);
        } catch (\Exception $e) {
            $this->logger->error('Failed to attach file to invoice', ['exception' => $e]);
            return ['error' => $e->getMessage()];
        }
    }
}
