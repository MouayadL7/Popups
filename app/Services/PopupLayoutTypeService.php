<?php

namespace App\Services;

use App\Models\PopupLayoutType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class PopupLayoutTypeService
{
    /**
     * Get popup layout types.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPopupLayoutTypes(): Collection
    {
        return PopupLayoutType::all();
    }

    /**
     * Create and store a new popup layout type object.
     *
     * @param array $data
     * @return PopupLayoutType
     */
    public function createPopupLayoutType(array $data): PopupLayoutType
    {
        // Start a transaction to ensure the popup type is saved atomically
        return DB::transaction(function () use ($data) {
            // Create the popup type
            return PopupLayoutType::create([
                'name' => $data['name']
            ]);
        });
    }

    /**
     * Update a popup layout type object.
     *
     * @param PopupLayoutType $popupLayoutType
     * @param array $data
     * @return PopupLayoutType
     */
    public function updatePopupLayoutType(PopupLayoutType $popupLayoutType, array $data): PopupLayoutType
    {
        $popupLayoutType->update($data);

        return $popupLayoutType;
    }

    /**
     * Delete a popup layout type object
     *
     * @param PopupLayoutType $popupLayoutType
     * @return void
     */
    public function deletePopupLayoutType(PopupLayoutType $popupLayoutType): void
    {
        // Delete the popup layout type and related data (due to cascading delete in DB schema)
        $popupLayoutType->delete();
    }
}
