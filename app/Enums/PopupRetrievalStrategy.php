<?php

namespace App\Enums;

enum PopupRetrievalStrategy: string
{
    case OWNER  = 'owner';
    case PAGE   = 'page';
    case FILTER = 'filter';

    public static function all(): array
    {
        return [
            self::OWNER,
            self::PAGE,
            self::FILTER,
        ];
    }
}
