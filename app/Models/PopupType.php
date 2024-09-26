<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PopupType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     * The 'fillable' property defines the attributes that can be mass assigned
     * when creating or updating a PopupType model instance.
     */
    protected $fillable = ['name'];

    /**
     * Get the popups for the type.
     *
     * @return HasMany
     *
     * This method defines a one-to-many relationship where a layout can have many popups.
     * Each popup is represented by a record in the 'popups' table.
     */
    public function popups(): HasMany
    {
        return $this->hasMany(Popup::class);
    }
}
