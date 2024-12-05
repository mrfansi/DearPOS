<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSupplier extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'supplier_id',
        'supplier_sku',
        'purchase_price',
        'minimum_order_quantity',
        'lead_time_days',
        'is_preferred',
        'last_purchase_date'
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'minimum_order_quantity' => 'integer',
        'lead_time_days' => 'integer',
        'is_preferred' => 'boolean',
        'last_purchase_date' => 'datetime'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function updatePrice(float $price): bool
    {
        $this->purchase_price = $price;
        return $this->save();
    }
}
