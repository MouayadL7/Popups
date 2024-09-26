<?php

namespace App\Services\Analytics;

use App\Contracts\PopupAnalyticsStrategyContract;
use InvalidArgumentException;

class PopupAnalyticsFactory
{
    public static function getStrategy(string $type): PopupAnalyticsStrategyContract
    {
        switch ($type) {
            case 'pages':
                return new TopPagesStrategy();
            case 'devices':
                return new TopDevicesStrategy();
            case 'variants':
                return new TopVariantsStrategy();
            default:
                throw new InvalidArgumentException('Unknown analytics type');
        }
    }
}
