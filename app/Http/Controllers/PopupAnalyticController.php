<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\PopupAnalyticRequest;
use App\Http\Requests\ToAnalyticRequest;
use App\Models\PopupAnalytic;
use App\Services\Analytics\PopupAnalyticsFactory;
use App\Services\PopupAnslyticService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Controller for managing popup analytics, including views, clicks, conversions,
 * and retrieving top analytics by type.
 */
class PopupAnalyticController extends Controller
{
    protected $popupAnalyticService;

    /**
     * PopupAnalyticController constructor.
     *
     * @param PopupAnalyticController $popupAnalyticService The service to handle popup analytic operations
     */
    public function __construct(PopupAnslyticService $popupAnalyticService)
    {
        // Injecting the PopupAnslyticService to handle business logic
        $this->popupAnalyticService = $popupAnalyticService;
    }

    /**
     * Add a new view to the analytics for a specific popup's variant.
     *
     * @param PopupAnalyticRequest $request
     * @return JsonResponse
     */
    public function addView(PopupAnalyticRequest $request)
    {
        // Delegate to the service to handle adding the view to the analytics
        $this->popupAnalyticService->addNewView($request->validated());

        return ResponseHelper::sendResponse([], 'View added successfully');
    }

    /**
     * Add a new click to the analytics for a specific popup's variant.
     *
     * @param PopupAnalyticRequest $request
     * @return JsonResponse
     */
    public function addClick(PopupAnalyticRequest $request)
    {
        // Delegate to the service to handle adding the click to the analytics
        $this->popupAnalyticService->addNewClick($request->validated());

        return ResponseHelper::sendResponse([], 'Click added successfully');
    }

    /**
     * Add a new conversion to the analytics for a specific popup's variant.
     *
     * @param PopupAnalyticRequest $request
     * @return JsonResponse
     */
    public function addConversion(PopupAnalyticRequest $request)
    {
        // Delegate to the service to handle adding the conversion to the analytics
        $this->popupAnalyticService->addNewConversion($request->validated());

        return ResponseHelper::sendResponse([], 'Conversion added successfully');
    }

    /**
     * Retrieve the analytics for all variants associated with a specific popup ID.
     * This returns analytics such as conversion rates, click-through rates, and bounce rates
     * for each variant related to the popup.
     *
     * @param int $popupId The ID of the popup
     * @return JsonResponse
     */
    public function showByPopupId($popupId)
    {
        // Delegate the logic to the service to retrieve analytics for all variants of the popup
        $analytics = $this->popupAnalyticService->getPopupAnalyticsByPopupId($popupId);

        // If no analytics data is found for the popup, return an error response
        if ($analytics->isEmpty()) {
            return ResponseHelper::sendError('No analytics found for this popup');
        }

        // Return the retrieved analytics data
        return ResponseHelper::sendResponse($analytics, '');
    }

    /**
     * Retrieve top analytics based on the given type (e.g., top devices, top pages, top variants).
     * The types are handled via a strategy pattern, allowing different types of analytics to be processed.
     *
     * @return JsonResponse
     */
    public function topAnalytics(): JsonResponse
    {
        // Delegate the request to the service to fetch top analytics for all types
        $topAnalytics = $this->popupAnalyticService->getAllTopAnalytics(request('limit'));

        // Return the top analytics data
        return ResponseHelper::sendResponse($topAnalytics, '');
    }
}
