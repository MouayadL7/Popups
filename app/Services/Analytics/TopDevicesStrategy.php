<?php

namespace App\Services\Analytics;

use App\Contracts\PopupAnalyticsStrategyContract;
use App\Helpers\AnalyticsHelper;
use App\Models\PopupAnalytic;
use Illuminate\Support\Facades\DB;

class TopDevicesStrategy implements PopupAnalyticsStrategyContract
{
    public function calculate(int $limit = 10)
    {
        return PopupAnalytic::select(
            'device_type',
            AnalyticsHelper::getAggregatedAnalytics()
        )
        ->groupBy('device_type')
        ->orderByDesc(AnalyticsHelper::calculateTotalEngagement())
        ->limit($limit)
        ->get();
    }
}
