<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceOrderItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'marketplace_order_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_id',
        'unit_price',
        'total_price',
        'discount_amount',
        'tax_amount',
        'fulfillment_status', // not_fulfilled, partially_fulfilled, fully_fulfilled
        'external_item_id',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'total_price' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'tax_amount' => 'decimal:4',
    ];

    /**
     * Get the parent marketplace order
     */
    public function marketplaceOrder(): BelongsTo
    {
        return $this->belongsTo(MarketplaceOrder::class, 'marketplace_order_id');
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    /**
     * Get the unit of measure
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    /**
     * Check if item is fully fulfilled
     */
    public function isFullyFulfilled(): bool
    {
        return $this->fulfillment_status === 'fully_fulfilled';
    }

    /**
     * Calculate net total after discounts
     */
    public function getNetTotalAttribute()
    {
        return $this->total_price - $this->discount_amount;
    }
}
