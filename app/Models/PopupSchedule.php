<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PopupSchedule extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * The 'fillable' property defines the attributes that can be mass assigned
     * when creating or updating a PopupSchedule model instance.
     */
    protected $fillable = ['variant_id', 'time_delay', 'display_pages'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     *
     * The 'casts' property specifies how certain attributes should be automatically
     * converted when retrieving them from the database. Here, 'display_pages' is cast to JSON.
     */
    protected $casts = [
        'display_pages' => 'json',
    ];

    /**
     * Get the variant of the schedule.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where an schedule belongs to a specific popup_variant.
     * The 'popup_id' field in the popup_schedules table references the popup_variants table.
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(PopupVariant::class, 'variant_id');
    }
}
