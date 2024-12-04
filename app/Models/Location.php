<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'locations';

    protected $fillable = [
        'name',
        'type', // e.g., warehouse, store, office
        'address',
        'parent_location_id',
    ];

    /**
     * Parent location relationship
     */
    public function parentLocation(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'parent_location_id');
    }

    /**
     * Child locations relationship
     */
    public function childLocations(): HasMany
    {
        return $this->hasMany(Location::class, 'parent_location_id');
    }

    /**
     * Scope a query to filter by location type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
