<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMovement extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'warehouse_id',
        'movement_type',
        'quantity',
        'unit_id',
        'reference_type',
        'reference_id',
        'lot_number',
        'expiry_date',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'expiry_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
