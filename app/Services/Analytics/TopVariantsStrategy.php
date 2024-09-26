<?php

namespace App\Services\Analytics;

use App\Contracts\PopupAnalyticsStrategyContract;
use App\Helpers\AnalyticsHelper;
use App\Models\PopupAnalytic;
use Illuminate\Support\Facades\DB;

class TopVariantsStrategy implements PopupAnalyticsStrategyContract
{
    public function calculate(int $limit = 10)
    {
        return PopupAnalytic::select(
            'variant_id',
            AnalyticsHelper::getAggregatedAnalytics()
        )
        ->groupBy('variant_id')
        ->orderByDesc(AnalyticsHelper::calculateTotalEngagement())
        ->limit($limit)
        ->get();
    }
}
