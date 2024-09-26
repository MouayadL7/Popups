<?php

namespace App\Enums;

enum PopupAnalyticsType: string
{
    case DEVICES  = 'devices';
    case PAGES    = 'pages';
    case VARIANTS = 'variants';

    public static function all(): array
    {
        return [
            self::DEVICES,
            self::PAGES,
            self::VARIANTS,
        ];
    }
}
