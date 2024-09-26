<?php

namespace App\Services;

use App\Models\PopupType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PopupTypeService
{
    /**
     * Get popup types.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPopupTypes(): Collection
    {
        return PopupType::all();
    }

    /**
     * Create and store a new popup type object.
     *
     * @param array $data
     * @return PopupType
     */
    public function createPopupType(array $data): PopupType
    {
        // Start a transaction to ensure the popup type is saved atomically
        return DB::transaction(function () use ($data) {
            // Create the popup type
            return PopupType::create([
                'name' => $data['name']
            ]);
        });
    }

    /**
     * Update a popup type object.
     *
     * @param PopupType $popupType
     * @param array $data
     * @return PopupType
     */
    public function updatePopupType(PopupType $popupType, array $data): PopupType
    {
        $popupType->update($data);

        return $popupType;
    }

    /**
     * Delete a popup type object
     *
     * @param PopupType $popupType
     * @return void
     */
    public function deletePopupType(PopupType $popupType): void
    {
        // Delete the popup type and related data (due to cascading delete in DB schema)
        $popupType->delete();
    }
}
