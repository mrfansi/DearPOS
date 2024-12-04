<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventorySerial extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'lot_id',
        'serial_number',
        'status',
    ];

    /**
     * Get the product associated with this serial
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this serial (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the lot associated with this serial (optional)
     */
    public function lot(): BelongsTo
    {
        return $this->belongsTo(InventoryLot::class, 'lot_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if the serial is available
     */
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    /**
     * Check if the serial is sold
     */
    public function isSold()
    {
        return $this->status === 'sold';
    }

    /**
     * Check if the serial is defective
     */
    public function isDefective()
    {
        return $this->status === 'defective';
    }
}
