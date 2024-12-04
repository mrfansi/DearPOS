<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'address',
        'contact_person',
        'contact_phone',
        'location_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the location associated with this warehouse
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the storage locations within this warehouse
     */
    public function storageLocations(): HasMany
    {
        return $this->hasMany(StorageLocation::class, 'warehouse_id');
    }

    /**
     * Get the total inventory in this warehouse
     */
    public function inventoryItems(): HasManyThrough
    {
        return $this->hasManyThrough(
            ProductLocation::class,
            StorageLocation::class,
            'warehouse_id',
            'location_id'
        );
    }

    /**
     * Scope a query to find active warehouses
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Calculate total inventory value in the warehouse
     */
    public function getTotalInventoryValueAttribute()
    {
        return $this->inventoryItems->sum(function ($item) {
            return $item->quantity * $item->product->current_cost;
        });
    }
}
