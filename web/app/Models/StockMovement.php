<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'variant_id',
        'location_id',
        'movement_type',
        'quantity',
        'unit_id',
        'reference_id',
        'reference_type',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    /**
     * Get the product associated with this stock movement
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the product variant associated with this stock movement (optional)
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the location associated with this stock movement
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get the unit of measure for this stock movement
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    /**
     * Get the user who created this stock movement
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope a query to filter by movement type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('movement_type', $type);
    }

    /**
     * Determine if the movement increases stock
     */
    public function isStockIncrease()
    {
        $increaseTypes = ['purchase', 'return', 'adjustment_add', 'transfer_in'];
        return in_array($this->movement_type, $increaseTypes);
    }

    /**
     * Determine if the movement decreases stock
     */
    public function isStockDecrease()
    {
        $decreaseTypes = ['sale', 'waste', 'adjustment_remove', 'transfer_out'];
        return in_array($this->movement_type, $decreaseTypes);
    }
}
