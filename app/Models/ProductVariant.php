<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariant extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'sku',
        'barcode',
        'price_adjustment',
        'stock_level',
        'is_active'
    ];

    protected $casts = [
        'price_adjustment' => 'float',
        'stock_level' => 'integer',
        'is_active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductVariantValue::class, 'variant_id');
    }
}
