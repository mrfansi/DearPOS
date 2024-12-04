<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'currency_id',
        'price_type',
        'amount',
        'effective_from',
        'effective_to',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'effective_from' => 'datetime',
        'effective_to' => 'datetime',
    ];

    /**
     * Get the product associated with the price
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /**
     * Get the currency associated with the price
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Scope a query to only include active prices
     */
    public function scopeActive($query)
    {
        return $query->where('effective_from', '<=', now())
                     ->where(function ($q) {
                         $q->whereNull('effective_to')
                           ->orWhere('effective_to', '>', now());
                     });
    }
}
