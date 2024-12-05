<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BundleItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'bundle_id',
        'product_id',
        'quantity',
        'price_adjustment'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price_adjustment' => 'decimal:2'
    ];

    public function bundle()
    {
        return $this->belongsTo(ProductBundle::class, 'bundle_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
