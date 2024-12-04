<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueueItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'queue_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_id',
        'special_instructions',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
    ];

    /**
     * Get the parent queue
     */
    public function queue(): BelongsTo
    {
        return $this->belongsTo(QueueManagement::class, 'queue_id');
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
}
