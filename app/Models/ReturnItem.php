<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ReturnItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'return_id',
        'product_id',
        'product_variant_id',
        'quantity',
        'unit_price',
        'total_amount',
        'reason',
        'condition'
    ];

    protected $casts = [
        'id' => 'string',
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'total_amount' => 'decimal:4'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Calculate total amount if not provided
            if (empty($model->total_amount)) {
                $model->total_amount = $model->quantity * $model->unit_price;
            }
        });
    }

    public function return()
    {
        return $this->belongsTo(ReturnRecord::class, 'return_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
