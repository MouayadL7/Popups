<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Popup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * The 'fillable' property defines the attributes that can be mass assigned
     * when creating or updating a Popup model instance.
     */
    protected $fillable = ['owner_id', 'type', 'layout', 'content'];

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
     * Get the owner of the popup.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where a popup belongs to a specific user (owner).
     * The 'owner_id' field in the popups table references the users table.
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Get the variants for the popup.
     *
     * @return HasMany
     *
     * This method defines a one-to-many relationship where a popup can have many variants.
     * Each variant is represented by a record in the 'popup_variants' table.
     */
    public function variants(): HasMany
    {
        return $this->hasMany(PopupVariant::class);
    }

    /**
     * Get the popup type.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where the popup belongs to a specific popup type.
     * The 'type_id' field in the popups table references the popup_types table.
     */
    public function popupType(): BelongsTo
    {
        return $this->belongsTo(PopupType::class, 'type_id');
    }

    /**
     * Get the popup layout type.
     *
     * @return BelongsTo
     *
     * This method defines a relationship where the popup belongs to a specific layout type.
     * The 'layout_type_id' field in the popups table references the popup_layout_types table.
     */
    public function popupLayoutType(): BelongsTo
    {
        return $this->belongsTo(PopupLayoutType::class, 'layout_type_id');
    }

    /**
     * Scope a query to include popups with their primary variant.
     *
     * This scope performs eager loading of the `variants` relationship and filters the variants
     * to include only the one where `is_primary` is true. This is useful for A/B testing where
     * you want to fetch only the primary variant associated with each popup.
     *
     * Usage Example:
     * ```php
     * $popups = Popup::withPrimaryVariant()->get();
     * ```
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithPrimaryVariant($query)
    {
        return $query->with(['variants' => function ($query) {
            $query->where('is_primary', true);
        }]);
    }
}
