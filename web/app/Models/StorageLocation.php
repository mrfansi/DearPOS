<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class StorageLocation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'warehouse_id',
        'name',
        'code',
        'type',
        'description',
        'is_active',
        'capacity',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
    ];

    /**
     * Get the warehouse associated with this storage location
     */
    public function warehouse(): BelongsTo
    {
        return $this->belongsTo(Warehouse::class, 'warehouse_id');
    }

    /**
     * Get the product locations in this storage location
     */
    public function productLocations(): HasMany
    {
        return $this->hasMany(ProductLocation::class, 'location_id');
    }

    /**
     * Scope a query to find active storage locations
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope a query to find storage locations by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Calculate current occupancy of the storage location
     */
    public function getCurrentOccupancyAttribute()
    {
        return $this->productLocations->sum('quantity');
    }

    /**
     * Check if the storage location is at full capacity
     */
    public function isAtFullCapacity()
    {
        return $this->capacity !== null && 
               $this->current_occupancy >= $this->capacity;
    }

    /**
     * Get the remaining capacity of the storage location
     */
    public function getRemainingCapacityAttribute()
    {
        if ($this->capacity === null) {
            return null;
        }

        return max(0, $this->capacity - $this->current_occupancy);
    }
}
