<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantValue extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'variant_id',
        'attribute_id',
        'value',
    ];

    /**
     * Get the product variant associated with this value
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    /**
     * Get the variant attribute associated with this value
     */
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(VariantAttribute::class, 'attribute_id');
    }

    /**
     * Scope a query to filter by specific variant
     */
    public function scopeForVariant($query, $variantId)
    {
        return $query->where('variant_id', $variantId);
    }

    /**
     * Scope a query to filter by specific attribute
     */
    public function scopeForAttribute($query, $attributeId)
    {
        return $query->where('attribute_id', $attributeId);
    }
}
