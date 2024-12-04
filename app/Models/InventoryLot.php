<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class InventoryLot extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'lot_number',
        'manufacturing_date',
        'expiry_date',
    ];

    protected $casts = [
        'manufacturing_date' => 'date',
        'expiry_date' => 'date',
    ];

    /**
     * Get the product associated with this lot
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this lot (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the transaction items for this lot
     */
    public function transactionItems(): HasMany
    {
        return $this->hasMany(InventoryTransactionItem::class, 'lot_id');
    }

    /**
     * Check if the lot is expired
     */
    public function isExpired()
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    /**
     * Check if the lot is close to expiry
     * 
     * @param int $daysThreshold Number of days before expiry to consider
     */
    public function isNearExpiry($daysThreshold = 30)
    {
        return $this->expiry_date && 
               $this->expiry_date->diffInDays(now()) <= $daysThreshold;
    }

    /**
     * Calculate the remaining shelf life
     */
    public function getRemainingShelfLifeAttribute()
    {
        if (!$this->expiry_date) {
            return null;
        }

        return now()->diffInDays($this->expiry_date);
    }

    /**
     * Get the current stock of this lot
     */
    public function getCurrentStockAttribute()
    {
        return $this->transactionItems()->sum('quantity');
    }
}
