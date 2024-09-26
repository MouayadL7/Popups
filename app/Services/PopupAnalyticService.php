<?php

namespace App\Services;

use App\Enums\PopupAnalyticsType;
use App\Models\PopupAnalytic;
use App\Services\Analytics\PopupAnalyticsFactory;
use Illuminate\Database\Eloquent\Collection;

class PopupAnslyticService
{
    /**
     * Check if a record exists.
     *
     * @param array $data
     * @return PopupAnalytic
     */
    public function checkIfRecordExists(array $data): PopupAnalytic|null
    {
        return PopupAnalytic::where('variant_id', $data['variant_id'])
                            ->where('page_url', $data['page_url'])
                            ->where('device_type', $data['device_type'])
                            ->first();
    }

    /**
     * Create a new record if needed.
     *
     * @param array $data
     * @return PopupAnalytic
     */
    public function createNewRecord(array $data): PopupAnalytic
    {
        return PopupAnalytic::create([
            'variant_id' => $data['variant_id'],
            'page_url' => $data['page_url'],
            'device_type' => $data['device_type']
        ]);
    }

    /**
     * Get or create the record.
     *
     * @param array $data
     * @return PopupAnalytic
     */
    public function getOrCreateRecord(array $data): PopupAnalytic
    {
        $popupAnalytic = $this->checkIfRecordExists($data);

        if (!$popupAnalytic) {
            return $this->createNewRecord($data);
        }

        return $popupAnalytic;
    }

    /**
     * Increment the 'views' count for a popup variant based on the provided data array.
     *
     * The data array should contain the following keys:
     * - 'variant_id': The ID of the popup variant.
     * - 'page_url': The URL of the page where the popup was displayed.
     * - 'device_type': The type of device (e.g., 'desktop', 'mobile').
     *
     * It first checks if a record for the given combination of `variant_id`,
     * `page_url`, and `device_type` exists. If the record does not exist,
     * it will create a new analytics record. Then, it increments the 'views'
     * count for that record.
     *
     * @param array $data  The data array containing 'variant_id', 'page_url', and 'device_type'.
     * @return void
     */
    public function addNewView(array $data): void
    {
        $popupAnalytic = $this->getOrCreateRecord($data);
        $popupAnalytic->increment('views');
    }

    /**
     * Increment the 'clicks' count for a popup variant based on the provided data array.
     *
     * The data array should contain the following keys:
     * - 'variant_id': The ID of the popup variant.
     * - 'page_url': The URL of the page where the popup was displayed.
     * - 'device_type': The type of device (e.g., 'desktop', 'mobile').
     *
     * It first checks if a record for the given combination of `variant_id`,
     * `page_url`, and `device_type` exists. If the record does not exist,
     * it will create a new analytics record. Then, it increments the 'clicks'
     * count for that record.
     *
     * @param array $data  The data array containing 'variant_id', 'page_url', and 'device_type'.
     * @return void
     */

    public function addNewClick(array $data): void
    {
        $popupAnalytic = $this->getOrCreateRecord($data);
        $popupAnalytic->increment('clicks');
    }

    /**
     * Increment the 'conversions' count for a popup variant based on the provided data array.
     *
     * The data array should contain the following keys:
     * - 'variant_id': The ID of the popup variant.
     * - 'page_url': The URL of the page where the popup was displayed.
     * - 'device_type': The type of device (e.g., 'desktop', 'mobile').
     *
     * It first checks if a record for the given combination of `variant_id`,
     * `page_url`, and `device_type` exists. If the record does not exist,
     * it will create a new analytics record. Then, it increments the 'conversions'
     * count for that record.
     *
     * @param array $data  The data array containing 'variant_id', 'page_url', and 'device_type'.
     * @return void
     */
    public function addNewConversion(array $data): void
    {
        $popupAnalytic = $this->getOrCreateRecord($data);
        $popupAnalytic->increment('conversions');
    }

    /**
     * Retrieve top analytics for all popup analytic types.
     *
     * @param int $limit The number of top results to retrieve for each analytic type (default is 10)
     * @return array An associative array of top analytics for each type
     *
     * This method loops through all available analytic types defined by the `PopupAnalyticsType` enum.
     * For each type, it retrieves the corresponding strategy using the `PopupAnalyticsFactory`, and calculates
     * the top analytics for that type using the specified limit.
     */
    public function getAllTopAnalytics(int $limit = 10): array
    {
        $result = [];

        // Loop through each analytic type and apply the corresponding strategy to fetch top analytics
        foreach (PopupAnalyticsType::all() as $type) {
            $strategy = PopupAnalyticsFactory::getStrategy($type->value);
            $result[$type->value] = $strategy->calculate($limit);
        }

        return $result;
    }

    /**
     * Retrieve and process analytics data for a specific popup by popup ID.
     *
     * @param int $popupId The ID of the popup to retrieve analytics for
     * @return \Illuminate\Support\Collection A collection of analytics grouped by variant, with calculated rates
     *
     * This method fetches analytics data for a given popup and groups them by `variant_id`.
     * It then calculates the conversion rate, click-through rate, and bounce rate for each variant.
     */
    public function getPopupAnalyticsByPopupId(int $popupId): Collection
    {
        // Fetch analytics for the specified popup and group them by variant
        $analytics = $this->fetchPopupAnalytics($popupId);
        return $this->groupAndCalculateRates($analytics);
    }

    /**
     * Fetch all popup analytics for a specific popup by popup ID.
     *
     * @param int $popupId The ID of the popup to retrieve analytics for
     * @return \Illuminate\Support\Collection A collection of popup analytics with the related variant
     *
     * This method retrieves all analytics associated with a specific popup, including its related variants.
     */
    protected function fetchPopupAnalytics(int $popupId): Collection
    {
        // Fetch popup analytics and include the related variant data
        return PopupAnalytic::with('variant')
            ->where('popup_id', $popupId)
            ->get();
    }

    /**
     * Group popup analytics by variant and calculate rates for each group.
     *
     * @param \Illuminate\Support\Collection $analytics A collection of popup analytics
     * @return \Illuminate\Support\Collection A collection of grouped analytics with calculated rates
     *
     * This method groups the analytics by `variant_id`, then calculates and formats the analytics data
     * for each variant, including conversion rate, click-through rate, and bounce rate.
     */
    protected function groupAndCalculateRates(Collection $analytics): Collection
    {
        // Group analytics by variant and calculate rates for each group
        return $analytics->groupBy('variant_id')->map(function ($variantAnalytics) {
            return $this->formatVariantAnalytics($variantAnalytics);
        });
    }

    /**
     * Format analytics data for a variant and calculate rates.
     *
     * @param \Illuminate\Support\Collection $variantAnalytics A collection of analytics for a specific variant
     * @return array An associative array containing the popup, variant, and calculated analytics data
     *
     * This method formats the analytics for a specific variant, including the full variant data and calculated
     * rates such as conversion rate, click-through rate, and bounce rate.
     */
    protected function formatVariantAnalytics(Collection $variantAnalytics): array
    {
        $firstRecord = $variantAnalytics->first(); // Fetch first record to retrieve variant and popup data

        // Format and return the variant analytics data
        return [
            'popup' => $firstRecord->popup,
            'variant' => $firstRecord->variant, // Full variant data
            'conversion_rate' => $this->calculateConversionRate($variantAnalytics),
            'click_through_rate' => $this->calculateClickThroughRate($variantAnalytics),
            'bounce_rate' => $this->calculateBounceRate($variantAnalytics),
        ];
    }

    /**
     * Calculate the conversion rate for a specific variant's analytics.
     *
     * @param \Illuminate\Support\Collection $variantAnalytics A collection of analytics for the variant
     * @return float The calculated conversion rate in percentage
     *
     * This method calculates the conversion rate by dividing the total conversions by the total views
     * and returning the result as a percentage.
     */
    protected function calculateConversionRate(Collection $variantAnalytics): float
    {
        $totalViews = $variantAnalytics->sum('views');
        $totalConversions = $variantAnalytics->sum('conversions');
        return $totalViews > 0 ? ($totalConversions / $totalViews) * 100 : 0;
    }

    /**
     * Calculate the click-through rate for a specific variant's analytics.
     *
     * @param \Illuminate\Support\Collection $variantAnalytics A collection of analytics for the variant
     * @return float The calculated click-through rate in percentage
     *
     * This method calculates the click-through rate by dividing the total clicks by the total views
     * and returning the result as a percentage.
     */
    protected function calculateClickThroughRate(Collection $variantAnalytics): float
    {
        $totalViews = $variantAnalytics->sum('views');
        $totalClicks = $variantAnalytics->sum('clicks');
        return $totalViews > 0 ? ($totalClicks / $totalViews) * 100 : 0;
    }

    /**
     * Calculate the bounce rate for a specific popup variant's analytics.
     *
     * @param \Illuminate\Support\Collection $variantAnalytics A collection of analytics data for a specific popup variant
     * @return float The calculated bounce rate as a percentage
     *
     * This method calculates the bounce rate for the variant by subtracting the total number of conversions from the total number of views (bounces),
     * dividing by the total number of views, and multiplying by 100 to get a percentage. If there are no views, it returns 0.
     */
    protected function calculateBounceRate(Collection $variantAnalytics): float
    {
        $totalViews = $variantAnalytics->sum('views');
        $totalConversions = $variantAnalytics->sum('conversions');
        $bounces = $totalViews - $totalConversions;
        return $totalViews > 0 ? ($bounces / $totalViews) * 100 : 0;
    }

}

