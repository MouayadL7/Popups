<?php

namespace App\Services\Analytics;

use App\Contracts\PopupAnalyticsStrategyContract;
use App\Helpers\AnalyticsHelper;
use App\Models\PopupAnalytic;
use Illuminate\Support\Facades\DB;

class TopPagesStrategy implements PopupAnalyticsStrategyContract
{
    public function calculate(int $limit = 10)
    {
        return PopupAnalytic::select(
            'page_url',
            AnalyticsHelper::getAggregatedAnalytics()
        )
        ->groupBy('page_url')
        ->orderByDesc(AnalyticsHelper::calculateTotalEngagement())
        ->limit($limit)
        ->get();
    }
}
