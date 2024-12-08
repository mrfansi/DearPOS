<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupplierReturnItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'supplier_return_id',
        'product_id',
        'quantity',
        'unit_cost',
        'total_amount',
        'reason',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'total_amount' => 'decimal:4',
    ];

    public function supplierReturn()
    {
        return $this->belongsTo(SupplierReturn::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
