<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StorePopupVariantRequest;
use App\Http\Requests\UpdatePopupVariantRequest;
use App\Http\Resources\PopupVariantResource;
use App\Models\Popup;
use App\Models\PopupVariant;
use App\Services\PopupVariantService;
use Illuminate\Http\Request;

class PopupVariantController extends Controller
{
    protected $popupVariantService;

    /**
     * PopupVariantController constructor.
     *
     * @param PopupVariantService $popupVariantService The service to handle popup variant operations
     */
    public function __construct(PopupVariantService $popupService)
    {
        // Injecting the PopupVariantService to handle business logic
        $this->popupVariantService = $popupService;
    }

    /**
     * Display a listing of popup variants for a specific popup.
     *
     * @param Popup $popup The popup for which to retrieve variants
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of popup variants
     *
     * This method retrieves all popup variants associated with the given popup.
     * The variants are returned as a JSON response.
     */
    public function index(Popup $popup)
    {
        // Fetch variants for the provided popup
        $popupVariants = $this->popupVariantService->getVariants($popup);

        // Return a JSON response containing the popup variants
        return ResponseHelper::sendResponse($popupVariants, 'Popup variants fetched successfully');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created popup variant in the database.
     *
     * @param StorePopupVariantRequest $request The validated request data for creating a popup variant
     * @return \Illuminate\Http\JsonResponse A JSON response with the created popup variant
     *
     * This method creates a new popup variant based on the validated input from the request.
     * It then returns the created variant as a JSON response.
     */
    public function store(StorePopupVariantRequest $request)
    {
        // Create a new popup variant with validated data
        $popupVariant = $this->popupVariantService->create($request->validated());

        // Return a JSON response with the newly created popup variant
        return ResponseHelper::sendResponse($popupVariant, 'Popup variant created successfully');
    }

    /**
     * Display the specified popup variant.
     *
     * @param PopupVariant $popupVariant The popup variant to display
     * @return \Illuminate\Http\JsonResponse A JSON response containing the popup variant
     *
     * This method returns the details of a specific popup variant.
     * The variant is returned as a JSON response.
     */
    public function show(PopupVariant $popupVariant)
    {
        // Transform and return the specified popup variant using PopupVariantResource as a JSON response
        return ResponseHelper::sendResponse(new PopupVariantResource($popupVariant), '');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PopupVariant $popupVariants)
    {
        //
    }

    /**
     * Update the specified popup variant in the database.
     *
     * @param UpdatePopupVariantRequest $request The validated request data for updating a popup variant
     * @param PopupVariant $popupVariant The popup variant to update
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated popup variant
     *
     * This method updates an existing popup variant with the validated data from the request.
     * It returns the updated popup variant as a JSON response.
     */
    public function update(UpdatePopupVariantRequest $request, PopupVariant $popupVariant)
    {
        // Update the popup variant with validated data
        $popupVariant = $this->popupVariantService->updatePopupVariant($popupVariant, $request->validated());

        // Transform and return the specified popup variant using PopupVariantResource as a JSON response
        return ResponseHelper::sendResponse(new PopupVariantResource($popupVariant), 'Popup variant updated successfully');
    }

    /**
     * Remove the specified popup variant from the database.
     *
     * @param PopupVariant $popupVariant The popup variant to delete
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful deletion
     *
     * This method deletes the specified popup variant from the database.
     * It returns a success message as a JSON response upon successful deletion.
     */
    public function destroy(PopupVariant $popupVariant)
    {
        // Delete the specified popup variant
        $this->popupVariantService->deletePopupVariant($popupVariant);

        // Return a JSON response confirming successful deletion
        return ResponseHelper::sendResponse([], 'Popup variant deleted successfully');
    }
}
