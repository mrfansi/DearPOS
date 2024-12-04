<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductBundle extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'bundle_product_id',
        'component_product_id',
        'quantity',
        'unit_id',
        'is_mandatory',
        'discount_percentage',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'is_mandatory' => 'boolean',
        'discount_percentage' => 'decimal:2',
    ];

    /**
     * Get the bundle product
     */
    public function bundleProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'bundle_product_id');
    }

    /**
     * Get the component product
     */
    public function componentProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'component_product_id');
    }

    /**
     * Get the unit of measure for the component quantity
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    /**
     * Calculate the discounted price of the component
     */
    public function getDiscountedPriceAttribute()
    {
        $componentPrice = $this->componentProduct->current_price;
        
        if ($this->discount_percentage) {
            return $componentPrice * (1 - ($this->discount_percentage / 100));
        }
        
        return $componentPrice;
    }

    /**
     * Scope a query to find bundles containing a specific product
     */
    public function scopeContainingProduct($query, $productId)
    {
        return $query->where('component_product_id', $productId);
    }

    /**
     * Scope a query to find mandatory bundle components
     */
    public function scopeMandatory($query)
    {
        return $query->where('is_mandatory', true);
    }
}
