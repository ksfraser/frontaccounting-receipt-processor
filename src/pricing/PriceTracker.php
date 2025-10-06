<?php

namespace App\Pricing;

class PriceTracker
{
    private array $priceHistory;

    public function __construct()
    {
        $this->priceHistory = [];
    }

    public function addPrice(string $itemId, float $price): void
    {
        if (!isset($this->priceHistory[$itemId])) {
            $this->priceHistory[$itemId] = [];
        }
        $this->priceHistory[$itemId][] = $price;
    }

    public function getPriceHistory(string $itemId): ?array
    {
        return $this->priceHistory[$itemId] ?? null;
    }

    public function getCurrentPrice(string $itemId): ?float
    {
        $prices = $this->priceHistory[$itemId] ?? null;
        return $prices ? end($prices) : null;
    }

    public function getAveragePrice(string $itemId): ?float
    {
        $prices = $this->priceHistory[$itemId] ?? null;
        if (!$prices || count($prices) === 0) {
            return null;
        }
        $total = array_sum($prices);
        return $total / count($prices);
    }

    public function getPriceProjection(string $itemId, int $futurePeriods): ?float
    {
        $currentPrice = $this->getCurrentPrice($itemId);
        $averagePrice = $this->getAveragePrice($itemId);
        if ($currentPrice === null || $averagePrice === null) {
            return null;
        }

        $projectedPrice = $currentPrice + ($currentPrice - $averagePrice) * $futurePeriods;
        return $projectedPrice;
    }

    public function getPriceData(): array
    {
        $result = [];
        foreach ($this->priceHistory as $itemId => $prices) {
            if (count($prices) > 0) {
                $result[] = ['itemId' => $itemId, 'price' => end($prices)];
            }
        }
        return $result;
    }
}
