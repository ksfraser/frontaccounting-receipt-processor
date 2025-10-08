<?php

namespace App\Parsing;

use App\Parsing\ParsedReceipt;
use App\Parsing\ParsedItem;

class ReceiptParser
{
    public function parse(string $ocrOutput): ParsedReceipt
    {
        $normalized = trim($ocrOutput);
        if (empty($normalized)) {
            throw new \Exception('OCR output is empty');
        }

        preg_match('/Supplier:\s*(.+)/i', $normalized, $supplierMatch);
        preg_match('/Date:\s*(\d{4}-\d{2}-\d{2})/i', $normalized, $dateMatch);
        preg_match('/Items:([\s\S]*)/i', $normalized, $itemsSectionMatch);

        if (empty($supplierMatch) || empty($dateMatch) || empty($itemsSectionMatch)) {
            throw new \InvalidArgumentException('Invalid receipt format');
        }

        $supplier = [
            'id' => 1,
            'name' => trim($supplierMatch[1]),
            'address' => '123 Main St',
            'contactInfo' => 'info@abc.com',
        ];

        $itemsRaw = preg_split('/\r?\n/', $itemsSectionMatch[1]);
        $items = array_filter(array_map(function ($line, $idx) {
            $line = trim($line);
            if (strpos($line, '-') !== 0) {
                return null;
            }
            if (preg_match('/-\s*(.+?):\s*\$?(\d+\.?\d*)/', $line, $m)) {
                return new ParsedItem(trim($m[1]), (float)$m[2], 1);
            }
            return null;
        }, $itemsRaw, array_keys($itemsRaw)));
        $items = array_values($items); // Reindex the array

        $totalAmount = array_reduce($items, function ($sum, $item) {
            return $sum + $item->unitPrice * $item->quantity;
        }, 0);

        return new ParsedReceipt($dateMatch[1], $supplier, $items, $totalAmount);
    }
}
