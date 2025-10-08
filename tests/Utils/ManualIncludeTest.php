<?php

namespace Tests\Utils;

use App\Utils\Errors\AppError;
use PHPUnit\Framework\TestCase;

class ManualIncludeTest extends TestCase
{
    public function testManualInclude(): void
    {
        $error = new AppError("Manual include test");
        $this->assertInstanceOf(AppError::class, $error);
        $this->assertEquals("AppError", $error->name);
        $this->assertEquals("Manual include test", $error->getMessage());
    }
}
