<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StorePopupLayoutTypeRequest;
use App\Http\Requests\UpdatePopupLayoutTypeRequest;
use App\Models\PopupLayoutType;
use App\Services\PopupLayoutTypeService;
use Illuminate\Http\Request;

class PopupLayoutTypeController extends Controller
{
    protected $popupLayoutTypeService;

    /**
     * PopupLayoutTypeController constructor.
     *
     * @param PopupLayoutTypeController $popupLayoutTypeController The service to handle popup layout type operations
     */
    public function __construct(PopupLayoutTypeService $popupLayoutTypeService)
    {
        // Injecting the PopupLayoutTypeService to handle business logic
        $this->popupLayoutTypeService = $popupLayoutTypeService;
    }

    /**
     * Display a listing of popup layout types.
     *
     * Fetches all popup layout types from the service and returns them in the response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        // Fetch all popup layout types
        $popupLayoutTypes = $this->popupLayoutTypeService->getPopupLayoutTypes();

        // Return a JSON response containing the popup layouy types
        return ResponseHelper::sendResponse($popupLayoutTypes, '');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created popup layout type in the database.
     *
     * @param StorePopupLayoutTypeRequest $request The validated request data for creating a popup layout type
     * @return \Illuminate\Http\JsonResponse A JSON response with the created popup layout type
     *
     * This method creates a new popup layout type based on the validated input from the request.
     * It then returns the created layout type as a JSON response.
     */
    public function store(StorePopupLayoutTypeRequest $request)
    {
        // Create a new popup layout type with validated data
        $popupLayoutType = $this->popupLayoutTypeService->createPopupLayoutType($request->validated());

        // Return a JSON response with the newly created popup layout type
        return ResponseHelper::sendResponse($popupLayoutType, 'Popup layout type created successfully');
    }

    /**
     * Display the specified popup layout type.
     *
     * @param PopupLayoutType $popuplayout type The popup layout type to display
     * @return \Illuminate\Http\JsonResponse A JSON response containing the popup layout type
     *
     * This method returns the details of a specific popup layout type.
     * The layout type is returned as a JSON response.
     */
    public function show(PopupLayoutType $popupLayoutType)
    {
        // Return a JSON response with the details of the specified popup layout type
        return ResponseHelper::sendResponse($popupLayoutType, '');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PopupLayoutType $popupLayoutType)
    {
        //
    }

    /**
     * Update the specified popup layout type in the database.
     *
     * @param UpdatePopupLayoutTypeRequest $request The validated request data for updating a popup layout type
     * @param PopupLayoutType $popupLayoutType The popup layout type to update
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated popup layout type
     *
     * This method updates an existing popup layout type with the validated data from the request.
     * It returns the updated popup layout type as a JSON response.
     */
    public function update(UpdatePopupLayoutTypeRequest $request, PopupLayoutType $popupLayoutType)
    {
        // Update the popup layout type with validated data
        $popupLayoutType = $this->popupLayoutTypeService->updatePopupLayoutType($popupLayoutType, $request->validated());

        // Return a JSON response with the updated popup layout type
        return ResponseHelper::sendResponse($popupLayoutType, 'Popup layout type updated successfully');
    }

    /**
     * Remove the specified popup layout type from the database.
     *
     * @param PopupLayoutType $popupLayoutType The popup layout type to delete
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful deletion
     *
     * This method deletes the specified popup layout type from the database.
     * It returns a success message as a JSON response upon successful deletion.
     */
    public function destroy(PopupLayoutType $popupLayoutType)
    {
        // Delete the specified popup layout type
        $this->popupLayoutTypeService->deletePopupLayoutType($popupLayoutType);

        // Return a JSON response confirming successful deletion
        return ResponseHelper::sendResponse([], 'Popup layout type deleted successfully');
    }
}
