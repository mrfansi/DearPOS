<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'invoice_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_id',
        'unit_price',
        'total_price',
        'discount_amount',
        'tax_amount',
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
     * Get the parent invoice
     */
    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
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
     * Calculate line item total after discounts
     */
    public function getNetTotalAttribute()
    {
        return $this->total_price - $this->discount_amount;
    }
}
