<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariantValue extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'variant_id',
        'attribute_id',
        'value'
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }
}
