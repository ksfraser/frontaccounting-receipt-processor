# UsageTracker Documentation

## Overview
The `UsageTracker` class is responsible for tracking the usage of items. It maintains usage data, including the count and the last used date for each item.

## Methods

### trackUsage
- **Description**: Tracks the usage of an item by incrementing its count and updating the last used date.
- **Parameters**: `string $itemId`
- **Return Type**: `void`

### getUsage
- **Description**: Retrieves the usage data for a specific item.
- **Parameters**: `string $itemId`
- **Return Type**: `?array`

### getAllUsage
- **Description**: Retrieves usage data for all items.
- **Parameters**: None
- **Return Type**: `array`

### clearUsage
- **Description**: Clears the usage data for a specific item.
- **Parameters**: `string $itemId`
- **Return Type**: `void`

### getUsageData
- **Description**: Retrieves a summary of usage data, interpreting the count as quantity.
- **Parameters**: None
- **Return Type**: `array`

## Usage Example
```php
$tracker = new UsageTracker();
$tracker->trackUsage('item1');
$tracker->trackUsage('item1');

$usage = $tracker->getUsage('item1');
print_r($usage);

$allUsage = $tracker->getAllUsage();
print_r($allUsage);

$tracker->clearUsage('item1');
```
