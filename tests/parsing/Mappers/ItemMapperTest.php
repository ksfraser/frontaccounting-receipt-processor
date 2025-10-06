<?php

use PHPUnit\Framework\TestCase;
use App\Parsing\Mappers\ItemMapper;
use App\Parsing\Mappers\Item;

class ItemMapperTest extends TestCase
{
    public function testMapItemData(): void
    {
        $parsedData = [
            'itemId' => '456',
            'itemName' => 'Test Item',
            'itemQuantity' => 10,
            'itemPrice' => 99.99
        ];

        $item = ItemMapper::mapItemData($parsedData);

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals('456', $item->getId());
        $this->assertEquals('Test Item', $item->getName());
        $this->assertEquals(10, $item->getQuantity());
        $this->assertEquals(99.99, $item->getPrice());
    }
}
