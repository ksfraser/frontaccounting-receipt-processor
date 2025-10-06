<?php

namespace App\Parsing;

class ReceiptParser
{
    public function parse(string $ocrOutput): array
    {
        $normalized = trim($ocrOutput);
        if (empty($normalized)) {
            return [
                'supplier' => ['id' => 1, 'name' => '', 'address' => '', 'contactInfo' => ''],
                'date' => '',
                'items' => [],
                'totalAmount' => 0
            ];
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
                return ['id' => $idx + 1, 'name' => trim($m[1]), 'quantity' => 1, 'price' => (float)$m[2]];
            }
            return null;
        }, $itemsRaw, array_keys($itemsRaw)));

        $totalAmount = array_reduce($items, function ($sum, $item) {
            return $sum + $item['price'] * $item['quantity'];
        }, 0);

        return [
            'supplier' => $supplier,
            'date' => $dateMatch[1],
            'items' => $items,
            'totalAmount' => $totalAmount
        ];
    }
}
