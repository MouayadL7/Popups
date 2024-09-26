<?php

namespace App\Services;

use App\Http\Resources\PopupVariantResource;
use App\Models\Popup;
use App\Models\PopupVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class PopupVariantService
{
    /**
     * Get popup variants for a specific popup.
     *
     * @param Popup $popup
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getVariants(Popup $popup): AnonymousResourceCollection
    {
        return PopupVariantResource::collection($popup->variants);
    }

    /**
     * Create and store a new popup object.
     *
     * @param array $data
     * @return PopupVariant
     */
    public function create(array $data): PopupVariant
    {
        // Start a transaction to ensure the popup variant is saved atomically
        return DB::transaction(function () use ($data) {
            // Create the popup variant
            return PopupVariant::create([
                'popup_id' => $data['popup_id'],
                'name' => $data['name'],
                'content' => json_encode($data['content']),
                'is_primary' => false
            ]);
        });
    }

    /**
     * Update a popup variant object.
     *
     * @param PopupVariant $popupVariant
     * @param array $data
     * @return PopupVariant
     */
    public function updatePopupVariant(PopupVariant $popupVariant, array $data): PopupVariant
    {
        $popupVariant->update($data);

        return $popupVariant;
    }

    /**
     * Delete a popup variant object
     *
     * @param PopupVariant $popupVariant
     * @return void
     */
    public function deletePopupVariant(PopupVariant $popupVariant): void
    {
        // Delete the popup variant and related data (due to cascading delete in DB schema)
        $popupVariant->delete();
    }
}
