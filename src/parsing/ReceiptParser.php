<?php

namespace App\Parsing;

class ParsedSupplier {
    public string $id;
    public string $name;
    public string $contactInfo;
}

class ParsedItem {
    public string $id;
    public string $description;
    public float $quantity;
    public float $unitPrice;
    public float $totalPrice;
}

class ParsedReceipt {
    public string $id;
    public string $supplierId;
    public string $date;
    public float $totalAmount;
    public string $currency;
    /** @var ParsedItem[] */
    public array $items;
}

class ReceiptParser {
    public function parse(string $ocrOutput): ParsedReceipt {
        $normalized = trim($ocrOutput);
        if (empty($normalized)) {
            throw new \Exception('OCR output is empty');
        }

        preg_match('/Supplier:\s*(.+)/i', $normalized, $supplierMatch);
        preg_match('/Date:\s*(\d{4}-\d{2}-\d{2})/i', $normalized, $dateMatch);
        preg_match('/Items:([\s\S]*)/i', $normalized, $itemsSectionMatch);

        if (empty($supplierMatch) || empty($dateMatch) || empty($itemsSectionMatch)) {
            throw new \Exception('Invalid receipt format');
        }

        $parsedReceipt = new ParsedReceipt();
        $parsedReceipt->id = uniqid();
        $parsedReceipt->supplierId = 'example-supplier-id';
        $parsedReceipt->date = $dateMatch[1];
        $parsedReceipt->totalAmount = 0.0;
        $parsedReceipt->currency = 'USD';
        $parsedReceipt->items = [];

        $itemsRaw = preg_split('/\r?\n/', $itemsSectionMatch[1]);
        foreach ($itemsRaw as $idx => $line) {
            $line = trim($line);
            if (strpos($line, '-') === 0) {
                if (preg_match('/-\s*(.+?):\s*\$?(\d+\.?\d*)/', $line, $m)) {
                    $item = new ParsedItem();
                    $item->id = (string)($idx + 1);
                    $item->description = trim($m[1]);
                    $item->quantity = 1;
                    $item->unitPrice = (float)$m[2];
                    $item->totalPrice = $item->unitPrice * $item->quantity;
                    $parsedReceipt->items[] = $item;
                    $parsedReceipt->totalAmount += $item->totalPrice;
                }
            }
        }

        return $parsedReceipt;
    }
}
