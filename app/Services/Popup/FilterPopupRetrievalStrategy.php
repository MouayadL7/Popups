<?php

namespace App\Services\Popup;

use App\Contracts\PopupRetrievalStrategyContract;
use App\Http\Resources\PopupResource;
use App\Models\Popup;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class FilterPopupRetrievalStrategy implements PopupRetrievalStrategyContract
{
    /**
     * Get popups by multiple conditions.
     *
     * @param array $data
     */
    public function getPopups(array $data): AnonymousResourceCollection
    {
        $query = Popup::query()->where('owner_id', Auth::id());

        if (isset($data['type_id'])) {
            $query->where('type_id', $data['type_id']);
        }

        if (isset($data['layout_type_id'])) {
            $query->where('layout_type_id', $data['layout_type_id']);
        }

        $popups = $query->withPrimaryVariant()->get();

        return PopupResource::collection($popups);
    }
}
