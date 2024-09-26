<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\GetPopupRequest;
use App\Http\Requests\StorePopupRequest;
use App\Http\Requests\UpdatePopupRequest;
use App\Http\Resources\PopupResource;
use App\Models\Popup;
use App\Services\PopupService;
use Illuminate\Http\Request;

class PopupController extends Controller
{
    protected $popupService;

    /**
     * PopupController constructor.
     *
     * @param PopupService $popupService The service to handle popup operations
     */
    public function __construct(PopupService $popupService)
    {
        // Injecting the PopupService to handle business logic
        $this->popupService = $popupService;
    }

    /**
     * Handle popup retrieval based on strategy type
     *
     * Depending on the request type (owner, page, filters), the appropriate
     * strategy is used to retrieve popups.
     *
     * @param GetPopupRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getPopups(GetPopupRequest $request)
    {
        // Use the PopupService to get popups based on the request and strategy type
        $popups = $this->popupService->getPopups($request->validated());

        // Return a JSON response containing the list of popups
        return ResponseHelper::sendResponse($popups, 'Popups fetched successfully');
    }

    /**
     * Display a listing of the popups.
     *
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of popups
     *
     * This method retrieves all the popups that belong to the current user, using the `myPopups()` method
     * from the `PopupService` to filter the user's popups.
     *
     * Each popup includes its primary variant, and the results are wrapped in a `PopupResource` collection.
     * The `myPopups()` method now returns an `AnonymousResourceCollection`, which is formatted as a JSON
     * response containing the popups and a success message.
     */
    public function index()
    {
        // Retrieve the current user's popups, including primary variants, using the popup service
        $popups = $this->popupService->myPopups();

        // Return a JSON response with the popup data, wrapped in PopupResource collection
        return ResponseHelper::sendResponse($popups, 'Popups with primary variants fetched successfully');
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created popup in the database.
     *
     * @param StorePopupRequest $request The validated request data for creating a popup
     * @return \Illuminate\Http\JsonResponse A JSON response with the created popup
     *
     * This method creates a new popup based on the validated input from the request.
     * It then returns the created popup as a JSON response.
     */
    public function store(StorePopupRequest $request)
    {
        // Create a new popup with validated data
        $popup = $this->popupService->createPopup($request->validated());

        // Return a JSON response with the newly created popup
        return ResponseHelper::sendResponse($popup, 'Popup created successfully');
    }

    /**
     * Display the specified popup.
     *
     * @param Popup $popup The popup to display
     * @return \Illuminate\Http\JsonResponse A JSON response containing the popup
     *
     * This method returns the details of a specific popup.
     * The is returned as a JSON response.
     */
    public function show(Popup $popup)
    {
        // Retrieve the popup details
        $popup = $this->popupService->getPopup($popup);

        // Return a JSON response with the details of the specified popup
        return ResponseHelper::sendResponse($popup, '');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Popup $popup)
    {
        //
    }

    /**
     * Update the specified popup in the database.
     *
     * @param UpdatePopupRequest $request The validated request data for updating a popup
     * @param Popup $popup The popup to update
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated popup
     *
     * This method updates an existing popup with the validated data from the request.
     * It returns the updated popup as a JSON response.
     */
    public function update(UpdatePopupRequest $request, Popup $popup)
    {
        // Update the popup with validated data
        $popup = $this->popupService->updatePopup($popup, $request->validated());

        // Transform and return the specified popup using PopupResource as a JSON response
        return ResponseHelper::sendResponse(new PopupResource($popup), 'Popup updated successfully');
    }

    /**
     * Remove the specified popup from the database.
     *
     * @param Popup $popup The popup to delete
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful deletion
     *
     * This method deletes the specified popup from the database.
     * It returns a success message as a JSON response upon successful deletion.
     */
    public function destroy(Popup $popup)
    {
        // Delete the specified popup
        $this->popupService->deletePopup($popup);

        // Return a JSON response confirming successful deletion
        return ResponseHelper::sendResponse([], 'Popup deleted successfully');
    }
}
