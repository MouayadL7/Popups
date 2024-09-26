<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StorePopupScheduleRequest;
use App\Http\Requests\UpdatePopupScheduleRequest;
use App\Models\PopupSchedule;
use App\Models\PopupVariant;
use App\Services\PopupScheduleService;
use Illuminate\Http\Request;

class PopupScheduleController extends Controller
{
    protected $popupScheduleService;

    /**
     * PopupScheduleController constructor.
     *
     * @param PopupScheduleService $popupScheduleService The service to handle popup schedule operations
     */
    public function __construct(PopupScheduleService $popupScheduleService)
    {
        // Injecting the PopupScheduleService to handle business logic
        $this->popupScheduleService = $popupScheduleService;
    }

    /**
     * Display a listing of popup schedules for a specific popup variant.
     *
     * @param PopupVariant $popupVariant The popup variant for which to retrieve schedules
     * @return \Illuminate\Http\JsonResponse A JSON response containing the list of popup schedules
     *
     * This method retrieves all popup schedules associated with the given popup variant.
     * The schedules are returned as a JSON response.
     */
    public function index(PopupVariant $popupVariant)
    {
        // Fetch schedules for the provided popup variant
        $popupSchedules = $this->popupScheduleService->getSchedules($popupVariant);

        // Return a JSON response containing the popup schedules
        return ResponseHelper::sendResponse($popupSchedules, '');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created popup schedule in the database.
     *
     * @param StorePopupScheduleRequest $request The validated request data for creating a popup schedule
     * @return \Illuminate\Http\JsonResponse A JSON response with the created popup schedule
     *
     * This method creates a new popup schedule based on the validated input from the request.
     * It then returns the created schedule as a JSON response.
     */
    public function store(StorePopupScheduleRequest $request)
    {
        // Create a new popup schedule with validated data
        $popupSchedule = $this->popupScheduleService->create($request->validated());

        // Return a JSON response with the newly created popup schedule
        return ResponseHelper::sendResponse($popupSchedule, 'Popup schedule created successfully');
    }

    /**
     * Display the specified popup schedule.
     *
     * @param PopupSchedule $popupSchedule The popup schedule to display
     * @return \Illuminate\Http\JsonResponse A JSON response containing the popup schedule
     *
     * This method returns the details of a specific popup schedule.
     * The schedule is returned as a JSON response.
     */
    public function show(PopupSchedule $popupSchedule)
    {
        // Return a JSON response with the details of the specified popup schedule
        return ResponseHelper::sendResponse($popupSchedule, '');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PopupSchedule $popupSchedule)
    {
        //
    }

    /**
     * Update the specified popup schedule in the database.
     *
     * @param UpdatePopupScheduleRequest $request The validated request data for updating a popup schedule
     * @param PopupSchedule $popupSchedule The popup schedule to update
     * @return \Illuminate\Http\JsonResponse A JSON response with the updated popup schedule
     *
     * This method updates an existing popup schedule with the validated data from the request.
     * It returns the updated popup schedule as a JSON response.
     */
    public function update(UpdatePopupScheduleRequest $request, PopupSchedule $popupSchedule)
    {
        // Update the popup schedule with validated data
        $popupSchedule = $this->popupScheduleService->updatePopupSchedule($popupSchedule, $request->validated());

        // Return a JSON response with the updated popup schedule
        return ResponseHelper::sendResponse($popupSchedule, 'Popup schedule updated successfully');
    }

    /**
     * Remove the specified popup schedule from the database.
     *
     * @param PopupSchedule $popupSchedule The popup schedule to delete
     * @return \Illuminate\Http\JsonResponse A JSON response indicating successful deletion
     *
     * This method deletes the specified popup schedule from the database.
     * It returns a success message as a JSON response upon successful deletion.
     */
    public function destroy(PopupSchedule $popupSchedule)
    {
        // Delete the specified popup schedule
        $this->popupScheduleService->deletePopupSchedule($popupSchedule);

        // Return a JSON response confirming successful deletion
        return ResponseHelper::sendResponse([], 'Popup schedule deleted successfully');
    }
}
