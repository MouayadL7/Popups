<?php

namespace App\Services;

use App\Http\Resources\PopupResource;
use App\Models\Popup;
use App\Models\PopupVariant;
use App\Services\Popup\PopupRetrievalFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PopupService
{
    /**
     * Handle popup retrieval based on strategy type
     *
     * @param array $data
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPopups(array $data): AnonymousResourceCollection
    {
        $strategy = PopupRetrievalFactory::getStrategy($data['type']);
        return $strategy->getPopups($data);
    }


    /**
     * Retrieve a specific popup along with its primary variant.
     *
     * @param Popup $popup The popup to be retrieved
     * @return PopupResource A resource representation of the popup with its primary variant
     *
     * This method loads the primary variant for the given popup. It uses eager loading to only include the variant
     * where the `is_primary` field is set to true. The popup along with its primary variant is then returned as a
     * `PopupResource` for structured JSON output.
     */
    public function getPopup(Popup $popup): PopupResource
    {
        // Eager load only the primary variant associated with the popup
        $popup->load(['variants' => function ($query) {
            $query->where('is_primary', true);
        }]);

        // Return the popup wrapped in a PopupResource for JSON serialization
        return new PopupResource($popup);
    }


    /**
     * Retrieve all popups that belong to the authenticated user, including the primary variant for each popup.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection A collection of popups wrapped in PopupResource for the current user
     *
     * This method retrieves all popups owned by the currently authenticated user, filtering them by the user's `id`.
     * It uses the `WithPrimaryVariant` scope to include only the primary variant for each popup.
     * The method returns a collection of popups with their primary variants.
     */
    public function myPopups(): AnonymousResourceCollection
    {
        // Retrieve popups for the authenticated user with primary variants
        $popups = Popup::where('owner_id', Auth::id())
            ->WithPrimaryVariant()
            ->get();

        // Return a collection of PopupResource
        return PopupResource::collection($popups);
    }


    /**
     * Create and store a new popup object.
     *
     * @param array $data
     * @return PopupResource
     */
    public function createPopup(array $data): PopupResource
    {
        // Start a transaction to ensure the popup and its variant are saved atomically
        return DB::transaction(function () use ($data) {
            // Create the popup
            $popup = Popup::create([
                'title' => $data['title'],
                'type_id' => $data['type_id'],
                'layout_type_id' => $data['layout_type_id']
            ]);

            // Create the popup variant
            PopupVariant::create([
                'popup_id' => $popup->id,
                'name' => 'Primary',
                'content' => json_encode($data['content']),
                'is_primary' => true
            ]);

            return $this->getPopup($popup);
        });
    }

    /**
     * Update a popup object.
     *
     * @param Popup $popup
     * @param array $data
     * @return PopupResource
     */
    public function updatePopup(Popup $popup, array $data): PopupResource
    {
        $popup->update($data);

        return $this->getPopup($popup);
    }

    /**
     * Delete a popup object
     *
     * @param Popup $popup
     * @return void
     */
    public function deletePopup(Popup $popup): void
    {
        // Delete the popup and related data (due to cascading delete in DB schema)
        $popup->delete();
    }
}
