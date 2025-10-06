<?php

namespace Tests\Pricing;

use App\Pricing\PriceTracker;
use PHPUnit\Framework\TestCase;

class PriceTrackerTest extends TestCase
{
    private PriceTracker $priceTracker;

    protected function setUp(): void
    {
        $this->priceTracker = new PriceTracker();
    }

    public function testAddAndGetPriceHistory(): void
    {
        $this->priceTracker->addPrice('item1', 10.0);
        $this->priceTracker->addPrice('item1', 15.0);

        $priceHistory = $this->priceTracker->getPriceHistory('item1');
        $this->assertCount(2, $priceHistory);
        $this->assertEquals([10.0, 15.0], $priceHistory);
    }

    public function testGetCurrentPrice(): void
    {
        $this->priceTracker->addPrice('item1', 10.0);
        $this->priceTracker->addPrice('item1', 15.0);

        $currentPrice = $this->priceTracker->getCurrentPrice('item1');
        $this->assertEquals(15.0, $currentPrice);
    }

    public function testGetAveragePrice(): void
    {
        $this->priceTracker->addPrice('item1', 10.0);
        $this->priceTracker->addPrice('item1', 20.0);

        $averagePrice = $this->priceTracker->getAveragePrice('item1');
        $this->assertEquals(15.0, $averagePrice);
    }

    public function testGetPriceProjection(): void
    {
        $this->priceTracker->addPrice('item1', 10.0);
        $this->priceTracker->addPrice('item1', 20.0);

        $projection = $this->priceTracker->getPriceProjection('item1', 2);
        $this->assertEquals(30.0, $projection);
    }

    public function testGetPriceData(): void
    {
        $this->priceTracker->addPrice('item1', 10.0);
        $this->priceTracker->addPrice('item2', 20.0);

        $priceData = $this->priceTracker->getPriceData();
        $this->assertCount(2, $priceData);
        $this->assertEquals(['itemId' => 'item1', 'price' => 10.0], $priceData[0]);
        $this->assertEquals(['itemId' => 'item2', 'price' => 20.0], $priceData[1]);
    }
}
