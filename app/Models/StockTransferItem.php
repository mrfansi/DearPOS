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
        'stock_transfer_id',
        'product_id',
        'quantity',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function stockTransfer()
    {
        return $this->belongsTo(StockTransfer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
