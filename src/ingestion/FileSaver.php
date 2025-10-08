<?php

namespace App\Ingestion;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Psr\Log\LoggerInterface;

class FileSaver
{
    private string $uploadDir;
    private LoggerInterface $logger;

    public function __construct(string $uploadDir, LoggerInterface $logger)
    {
        $this->uploadDir = $uploadDir;
        $this->logger = $logger;
    }

    public function saveFile(UploadedFile $file): string
    {
        if (!is_dir($this->uploadDir)) {
            mkdir($this->uploadDir, 0777, true);
        }

        $filePath = $this->uploadDir . '/' . time() . '-' . $file->getClientOriginalName();
        $file->move($this->uploadDir, basename($filePath));

        $this->logger->info('File saved successfully', ['filePath' => $filePath]);

        return $filePath;
    }
}
