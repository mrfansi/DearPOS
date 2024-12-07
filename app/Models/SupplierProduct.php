<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierProduct extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'supplier_id',
        'product_id',
        'supplier_product_code',
        'supplier_product_name',
        'unit_cost',
        'minimum_order_quantity',
        'lead_time_days',
        'is_preferred',
        'notes'
    ];

    protected $casts = [
        'unit_cost' => 'decimal:4',
        'minimum_order_quantity' => 'decimal:4',
        'lead_time_days' => 'integer',
        'is_preferred' => 'boolean'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
};
