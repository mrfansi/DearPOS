<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransferItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'transfer_id',
        'product_id',
        'variant_id',
        'quantity',
        'unit_id',
        'from_location_id',
        'to_location_id',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    /**
     * Get the stock transfer
     */
    public function transfer(): BelongsTo
    {
        return $this->belongsTo(StockTransfer::class, 'transfer_id');
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
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the unit of measure
     */
    public function unit(): BelongsTo
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    /**
     * Get the source storage location
     */
    public function fromLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class, 'from_location_id');
    }

    /**
     * Get the destination storage location
     */
    public function toLocation(): BelongsTo
    {
        return $this->belongsTo(StorageLocation::class, 'to_location_id');
    }

    /**
     * Calculate the total value of the transfer item
     */
    public function getTotalValueAttribute()
    {
        return $this->quantity * $this->product->current_cost;
    }
}
