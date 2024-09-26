<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StorePopupTypeRequest;
use App\Http\Requests\UpdatePopupTypeRequest;
use App\Models\PopupType;
use App\Services\PopupTypeService;
use Illuminate\Http\Request;

class PopupTypeController extends Controller
{
    protected $popupTypeService;

    /**
     * PopupTypeController constructor.
     *
     * @param PopupTypeController $popupTypeController The service to handle popup type operations
     */
    public function __construct(PopupTypeService $popupTypeService)
    {
        // Injecting the PopupTypeService to handle business logic
        $this->popupTypeService = $popupTypeService;
    }

    /**
     * Display a listing of popup types.
     *
     * Fetches all popup types from the service and returns them in the response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all popup types
        $popupTypes = $this->popupTypeService->getPopupTypes();

        // Return a JSON response containing the popup types
        return ResponseHelper::sendResponse($popupTypes, '');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created popup type in the database.
     *
     * @param StorePopupTypeRequest $request The validated request data for creating a popup type
     * @return \Illuminate\Http\JsonResponse A JSON response with the created popup type
     *
     * This method creates a new popup type based on the validated input from the request.
     * It then returns the created type as a JSON response.
     */
    public function store(StorePopupTypeRequest $request)
    {
        // Create a new popup type using the validated data
        $popupType = $this->popupTypeService->createPopupType($request->validated());

        // Return a JSON response with the newly created popup type
        return ResponseHelper::sendResponse($popupType, 'Popup type created successfully');
    }

    /**
     * Display the specified popup type.
     *
     * @param PopupType $popupType The popup type to display
     * @return \Illuminate\Http\JsonResponse A JSON response containing the popup type
     *
     * This method returns the details of a specific popup type.
     * The type is returned as a JSON response.
     */
    public function show(PopupType $popupType)
    {
        // Return a JSON response with the details of the specified popup type
        return ResponseHelper::sendResponse($popupType, '');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PopupType $popupType)
    {
        //
    }

    /**
     * Update the specified popup type in the database.
     *
     * @param UpdatePopupTypeRequest $request The validated request data for updating a popup type
     * @param PopupType $popupType The popup type to update
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated popup type
     *
     * This method updates an existing popup type with the validated data from the request.
     * It returns the updated popup type as a JSON response.
     */
    public function update(UpdatePopupTypeRequest $request, PopupType $popupType)
    {
        // Update the popup type with validated data
        $popupType = $this->popupTypeService->updatePopupType($popupType, $request->validated());

        // Return a JSON response with the updated popup type
        return ResponseHelper::sendResponse($popupType, 'Popup type updated successfully');
    }

    /**
     * Remove the specified popup type from the database.
     *
     * @param PopupType $popupType The popup type to delete
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful deletion
     *
     * This method deletes the specified popup type from the database.
     * It returns a success message as a JSON response upon successful deletion.
     */
    public function destroy(PopupType $popupType)
    {
        // Delete the specified popup type
        $this->popupTypeService->deletePopupType($popupType);

        // Return a JSON response confirming successful deletion
        return ResponseHelper::sendResponse([], 'Popup type deleted successfully');
    }
}
