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
        'reason',
    ];

    protected $casts = [
        'quantity' => 'integer',
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
