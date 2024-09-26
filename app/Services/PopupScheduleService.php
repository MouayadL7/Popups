<?php

namespace App\Services;

use App\Models\PopupSchedule;
use App\Models\PopupVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PopupScheduleService
{
    /**
     * Get popupVariant schedules for a specific popupVariant.
     *
     * @param PopupVariant $popupVariant
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getSchedules(PopupVariant $popupVariant): Collection
    {
        return $popupVariant->schedules;
    }

    /**
     * Create and store a new popup object.
     *
     * @param array $data
     * @return PopupSchedule
     */
    public function create(array $data): PopupSchedule
    {
        // Start a transaction to ensure the popup schedule is saved atomically
        return DB::transaction(function () use ($data) {
            // Create the popup schedule
            return PopupSchedule::create([
                'variant_id' => $data['variant_id'],
                'time_delay' => $data['time_delay'],
                'dispaly_pages' => json_encode($data['display_pages'])
            ]);
        });
    }

    /**
     * Update a popup schedule object.
     *
     * @param PopupSchedule $popupSchedule
     * @param array $data
     * @return PopupSchedule
     */
    public function updatePopupSchedule(PopupSchedule $popupSchedule, array $data): PopupSchedule
    {
        $popupSchedule->update($data);

        return $popupSchedule;
    }

    /**
     * Delete a popup schedule object
     *
     * @param PopupSchedule $popupSchedule
     * @return void
     */
    public function deletePopupSchedule(PopupSchedule $popupSchedule): void
    {
        // Delete the popup schedule and related data (due to cascading delete in DB schema)
        $popupSchedule->delete();
    }
}
