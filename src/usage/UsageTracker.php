<?php

namespace App\Usage;

/**
 * Class UsageTracker
 *
 * Tracks the usage of items, including count and last used date.
 *
 * UML Diagram:
 * ```plantuml
 * @startuml
 * class UsageTracker {
 *     - array $usageData
 *     + __construct()
 *     + trackUsage(string $itemId): void
 *     + getUsage(string $itemId): ?array
 *     + getAllUsage(): array
 *     + clearUsage(string $itemId): void
 *     + getUsageData(): array
 * }
 * @enduml
 * ```
 */
class UsageTracker
{
    private array $usageData;

    public function __construct()
    {
        $this->usageData = [];
    }

    public function trackUsage(string $itemId): void
    {
        $currentDate = new \DateTime();
        if (isset($this->usageData[$itemId])) {
            $this->usageData[$itemId]['count'] += 1;
            $this->usageData[$itemId]['lastUsed'] = $currentDate;
        } else {
            $this->usageData[$itemId] = ['count' => 1, 'lastUsed' => $currentDate];
        }
    }

    public function getUsage(string $itemId): ?array
    {
        return $this->usageData[$itemId] ?? null;
    }

    public function getAllUsage(): array
    {
        return $this->usageData;
    }

    public function clearUsage(string $itemId): void
    {
        unset($this->usageData[$itemId]);
    }

    public function getUsageData(): array
    {
        return array_map(function ($itemId, $data) {
            return ['itemId' => $itemId, 'quantity' => $data['count']];
        }, array_keys($this->usageData), $this->usageData);
    }
}
