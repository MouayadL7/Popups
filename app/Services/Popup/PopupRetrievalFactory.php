<?php

namespace App\Services\Popup;

use App\Contracts\PopupRetrievalStrategyContract;

class PopupRetrievalFactory
{
    public static function getStrategy(string $type): PopupRetrievalStrategyContract
    {
        switch ($type) {
            case 'owner':
                return new OwnerPopupRetrievalStrategy();
            case 'page':
                return new PagePopupRetrievalStrategy();
            case 'filter':
                return new FilterPopupRetrievalStrategy();
            default:
                throw new \InvalidArgumentException("Invalid popup retrieval strategy");
        }
    }
}
