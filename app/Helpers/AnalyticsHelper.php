<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class AnalyticsHelper
{
    /**
     * Get the total engagement calculation.
     *
     * @return \Illuminate\Database\Query\Expression
     */
    public static function calculateTotalEngagement()
    {
        return DB::raw('SUM(views + clicks + conversions) as total_engagement');
    }

    /**
     * Get the aggregation for views, clicks, conversions.
     *
     * @return array
     */
    public static function getAggregatedAnalytics()
    {
        return [
            DB::raw('SUM(views) as total_views'),
            DB::raw('SUM(clicks) as total_clicks'),
            DB::raw('SUM(conversions) as total_conversions'),
        ];
    }
}
