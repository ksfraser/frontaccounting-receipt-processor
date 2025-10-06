<?php

namespace Tests\Items;

use App\Items\ItemService;
use App\Utils\Errors\AppError;
use PHPUnit\Framework\TestCase;

class ItemServiceTest extends TestCase
{
    private ItemService $itemService;

    protected function setUp(): void
    {
        $this->itemService = new ItemService();
    }

    public function testCreateItem(): void
    {
        $this->itemService->createItem('item1', 'Item 1', 10.0);
        $item = $this->itemService->getItem('item1');

        $this->assertNotNull($item);
        $this->assertEquals('Item 1', $item['name']);
        $this->assertEquals(10.0, $item['price']);
        $this->assertEquals(0, $item['usage']);
    }

    public function testCreateDuplicateItem(): void
    {
        $this->expectException(AppError::class);
        $this->expectExceptionMessage('Item already exists');

        $this->itemService->createItem('item1', 'Item 1', 10.0);
        $this->itemService->createItem('item1', 'Item 1', 10.0);
    }

    public function testUpdateItem(): void
    {
        $this->itemService->createItem('item1', 'Item 1', 10.0);
        $this->itemService->updateItem('item1', 'Updated Item 1', 15.0);

        $item = $this->itemService->getItem('item1');
        $this->assertEquals('Updated Item 1', $item['name']);
        $this->assertEquals(15.0, $item['price']);
    }

    public function testUpdateNonExistentItem(): void
    {
        $this->expectException(AppError::class);
        $this->expectExceptionMessage('Item not found');

        $this->itemService->updateItem('item1', 'Updated Item 1', 15.0);
    }

    public function testTrackUsage(): void
    {
        $this->itemService->createItem('item1', 'Item 1', 10.0);
        $this->itemService->trackUsage('item1', 5);

        $usage = $this->itemService->getUsage('item1');
        $this->assertEquals(5, $usage);
    }

    public function testTrackUsageNonExistentItem(): void
    {
        $this->expectException(AppError::class);
        $this->expectExceptionMessage('Item not found');

        $this->itemService->trackUsage('item1', 5);
    }

    public function testGetAllItems(): void
    {
        $this->itemService->createItem('item1', 'Item 1', 10.0);
        $this->itemService->createItem('item2', 'Item 2', 20.0);

        $allItems = $this->itemService->getAllItems();
        $this->assertCount(2, $allItems);
        $this->assertEquals('Item 1', $allItems[0]['name']);
        $this->assertEquals('Item 2', $allItems[1]['name']);
    }
}
