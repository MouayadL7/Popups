<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PopupAnalytic extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * The 'fillable' property defines the attributes that can be mass assigned
     * when creating or updating a PopupAnalytic model instance.
     */
    protected $fillable = [
        'popup_id',
        'variant_id',
        'views',
        'clicks',
        'conversions',
        'device_type',
        'page_url'
    ];

    /**
     * Get the popup of the analytic.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where an analytic belongs to a specific popup.
     * The 'popup_id' field in the popup_analytics table references the popups table.
     */
    public function popup(): BelongsTo
    {
        return $this->belongsTo(Popup::class);
    }

    /**
     * Get the variant of the analytic.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where an analytic belongs to a specific popup_variant.
     * The 'popup_id' field in the popup_analytics table references the popup_variants table.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(PopupVariant::class, 'variant_id');
    }
}
