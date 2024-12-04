<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductInventory extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'location_id',
        'minimum_stock',
        'reorder_point',
        'maximum_stock',
    ];

    protected $casts = [
        'minimum_stock' => 'decimal:4',
        'reorder_point' => 'decimal:4',
        'maximum_stock' => 'decimal:4',
    ];

    /**
     * Get the product associated with this inventory
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this inventory (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the location associated with this inventory
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Calculate current stock based on inventory transactions
     */
    public function getCurrentStockAttribute()
    {
        return InventoryTransaction::where('product_id', $this->product_id)
            ->where('location_id', $this->location_id)
            ->when($this->variant_id, function ($query) {
                return $query->where('variant_id', $this->variant_id);
            })
            ->sum('quantity');
    }

    /**
     * Check if stock is below reorder point
     */
    public function isLowStock()
    {
        return $this->current_stock <= $this->reorder_point;
    }

    /**
     * Check if stock is at or above maximum stock level
     */
    public function isStockFull()
    {
        return $this->current_stock >= $this->maximum_stock;
    }
}
