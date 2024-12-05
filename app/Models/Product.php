<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'brand',
        'unit',
        'weight',
        'length',
        'width',
        'height',
        'is_active',
        'is_service',
        'track_inventory',
        'min_stock_level',
        'reorder_point',
        'lead_time_days'
    ];

    protected $casts = [
        'weight' => 'float',
        'length' => 'float',
        'width' => 'float',
        'height' => 'float',
        'is_active' => 'boolean',
        'is_service' => 'boolean',
        'track_inventory' => 'boolean',
        'min_stock_level' => 'integer',
        'reorder_point' => 'integer',
        'lead_time_days' => 'integer'
    ];

    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttributeValue::class);
    }

    public function prices()
    {
        return $this->hasMany(ProductPrice::class);
    }

    public function barcodes()
    {
        return $this->hasMany(ProductBarcode::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function bundles()
    {
        return $this->belongsToMany(ProductBundle::class, 'bundle_items')
            ->withPivot(['quantity', 'price_adjustment'])
            ->withTimestamps();
    }

    public function recipes()
    {
        return $this->hasMany(ProductRecipe::class);
    }

    public function movements()
    {
        return $this->hasMany(ProductMovement::class);
    }

    public function suppliers()
    {
        return $this->hasMany(ProductSupplier::class);
    }

    public function isLowStock(): bool
    {
        return $this->checkStock() <= $this->min_stock_level;
    }

    public function checkStock(): int
    {
        return $this->variants->sum('stock_level');
    }

    public function needsReorder(): bool
    {
        return $this->checkStock() <= $this->reorder_point;
    }
}
