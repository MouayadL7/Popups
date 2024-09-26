<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PopupVariant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * The 'fillable' property defines the attributes that can be mass assigned
     * when creating or updating a PopupVariant model instance.
     */
    protected $fillable = ['popup_id', 'name', 'content', 'is_primary'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     *
     * The 'casts' property specifies how certain attributes should be automatically
     * converted when retrieving them from the database. Here, 'content' is cast to JSON.
     */
    protected $casts = [
        'content' => 'json',
    ];

    /**
     * Get the popup of the variant.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where a variant belongs to a specific popup.
     * The 'popup_id' field in the popup_variants table references the popups table.
     */
    public function popup(): BelongsTo
    {
        return $this->belongsTo(Popup::class);
    }

    /**
     * Get the analytics for the variant.
     *
     * @return HasMany
     *
     * This method defines a one-to-many relationship where a variant can have many popup_analytics.
     * Each analytic is represented by a record in the 'popup_analytics' table.
     */
    public function analytics(): HasMany
    {
        return $this->hasMany(PopupAnalytic::class, 'variant_id');
    }

    /**
     * Get the schedules for the variant.
     *
     * @return HasMany
     *
     * This method defines a one-to-many relationship where a variant can have many popup_schedules.
     * Each schedule is represented by a record in the 'popup_schedules' table.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(PopupSchedule::class, 'variant_id');
    }
}
