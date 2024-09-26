<?php

namespace App\Services\Popup;

use App\Contracts\PopupRetrievalStrategyContract;
use App\Http\Resources\PopupVariantResource;
use App\Models\Popup;
use App\Models\PopupVariant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PagePopupRetrievalStrategy implements PopupRetrievalStrategyContract
{
    /**
     * Get popups by page URL through popup schedules.
     *
     * @param array $data
     */
    public function getPopups(array $data): AnonymousResourceCollection
    {
        $popup_variants = PopupVariant::whereHas('schedules', function ($query) use ($data) {
            $query->whereJsonContains('display_pages', $data['page_url']);
        })
        ->get();

        return PopupVariantResource::collection($popup_variants);
    }
}
