<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransferItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'transfer_id',
        'product_id',
        'product_variant_id',
        'quantity_requested',
        'quantity_sent',
        'quantity_received',
        'unit_id',
        'lot_number',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'quantity_requested' => 'decimal:4',
        'quantity_sent' => 'decimal:4',
        'quantity_received' => 'decimal:4',
        'expiry_date' => 'date',
    ];

    public function transfer()
    {
        return $this->belongsTo(StockTransfer::class, 'transfer_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitOfMeasure::class, 'unit_id');
    }
}
