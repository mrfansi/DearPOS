<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductLocation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'location_id',
        'quantity',
        'unit_id',
        'min_stock_level',
        'max_stock_level',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'min_stock_level' => 'decimal:4',
        'max_stock_level' => 'decimal:4',
    ];

    /**
     * Get the product associated with this location stock
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this location stock (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the location associated with this stock
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the unit of measure for this stock
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    /**
     * Check if the stock is below minimum level
     */
    public function isBelowMinStock()
    {
        return $this->min_stock_level !== null && 
               $this->quantity < $this->min_stock_level;
    }

    /**
     * Check if the stock is above maximum level
     */
    public function isAboveMaxStock()
    {
        return $this->max_stock_level !== null && 
               $this->quantity > $this->max_stock_level;
    }

    /**
     * Scope a query to find products below minimum stock level
     */
    public function scopeBelowMinStock($query)
    {
        return $query->whereNotNull('min_stock_level')
                     ->whereColumn('quantity', '<', 'min_stock_level');
    }

    /**
     * Scope a query to find products above maximum stock level
     */
    public function scopeAboveMaxStock($query)
    {
        return $query->whereNotNull('max_stock_level')
                     ->whereColumn('quantity', '>', 'max_stock_level');
    }
}
