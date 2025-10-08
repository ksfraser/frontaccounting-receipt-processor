<?php

require 'src/Utils/Logger.php';

try {
    $loggerFactory = new App\Utils\LoggerFactory();
    echo "LoggerFactory loaded successfully." . PHP_EOL;
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . PHP_EOL;
}
