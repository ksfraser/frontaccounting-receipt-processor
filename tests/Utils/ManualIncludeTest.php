<?php

require __DIR__ . '/../../src/Utils/Errors/Errors.php';

use App\Utils\Errors\AppError;

function testManualInclude() {
    $error = new AppError("Manual include test");
    echo "Class loaded successfully: " . get_class($error) . PHP_EOL;
    echo "Error name: " . $error->name . PHP_EOL;
}

testManualInclude();
