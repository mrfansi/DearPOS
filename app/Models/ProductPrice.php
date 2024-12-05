<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductPrice extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'price_type',
        'base_price',
        'markup_percentage',
        'discount_percentage',
        'start_date',
        'end_date',
        'is_active'
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'markup_percentage' => 'decimal:2',
        'discount_percentage' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function calculateFinalPrice(): float
    {
        $price = $this->base_price;

        if ($this->markup_percentage > 0) {
            $price += ($price * $this->markup_percentage / 100);
        }

        if ($this->discount_percentage > 0) {
            $price -= ($price * $this->discount_percentage / 100);
        }

        return round($price, 2);
    }

    public function isValid(): bool
    {
        $now = now();

        if (!$this->is_active) {
            return false;
        }

        if ($this->start_date && $now < $this->start_date) {
            return false;
        }

        if ($this->end_date && $now > $this->end_date) {
            return false;
        }

        return true;
    }
}
