<?php

namespace Tests\Usage;

use App\Usage\UsageTracker;
use PHPUnit\Framework\TestCase;

class UsageTrackerTest extends TestCase
{
    private UsageTracker $usageTracker;

    protected function setUp(): void
    {
        $this->usageTracker = new UsageTracker();
    }

    public function testTrackUsage(): void
    {
        $this->usageTracker->trackUsage('item1');
        $usage = $this->usageTracker->getUsage('item1');

        $this->assertNotNull($usage);
        $this->assertEquals(1, $usage['count']);
        $this->assertInstanceOf(\DateTime::class, $usage['lastUsed']);
    }

    public function testGetUsage(): void
    {
        $this->usageTracker->trackUsage('item1');
        $usage = $this->usageTracker->getUsage('item1');

        $this->assertNotNull($usage);
        $this->assertEquals(1, $usage['count']);
    }

    public function testGetAllUsage(): void
    {
        $this->usageTracker->trackUsage('item1');
        $this->usageTracker->trackUsage('item2');

        $allUsage = $this->usageTracker->getAllUsage();

        $this->assertCount(2, $allUsage);
        $this->assertArrayHasKey('item1', $allUsage);
        $this->assertArrayHasKey('item2', $allUsage);
    }

    public function testClearUsage(): void
    {
        $this->usageTracker->trackUsage('item1');
        $this->usageTracker->clearUsage('item1');

        $usage = $this->usageTracker->getUsage('item1');
        $this->assertNull($usage);
    }

    public function testGetUsageData(): void
    {
        $this->usageTracker->trackUsage('item1');
        $this->usageTracker->trackUsage('item1');

        $usageData = $this->usageTracker->getUsageData();

        $this->assertCount(1, $usageData);
        $this->assertEquals('item1', $usageData[0]['itemId']);
        $this->assertEquals(2, $usageData[0]['quantity']);
    }
}
