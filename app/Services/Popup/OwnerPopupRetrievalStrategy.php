<?php

namespace App\Services\Popup;

use App\Contracts\PopupRetrievalStrategyContract;
use App\Http\Resources\PopupResource;
use App\Models\Popup;
use App\Models\PopupVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OwnerPopupRetrievalStrategy implements PopupRetrievalStrategyContract
{
    /**
     * Get popups for a specific owner.
     *
     * @param array $data
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function getPopups(array $data): AnonymousResourceCollection
    {
        $popups = Popup::where('owner_id', $data['owner_id'])
            ->withPrimaryVariant()
            ->get();

        return PopupResource::collection($popups);
    }
}
