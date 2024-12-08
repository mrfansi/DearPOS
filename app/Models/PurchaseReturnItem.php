<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseReturnItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_return_items';

    protected $fillable = [
        'return_id',
        'purchase_order_item_id',
        'quantity',
        'unit_price',
        'total_amount',
        'reason',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'total_amount' => 'decimal:4'
    ];

    public function purchaseReturn()
    {
        return $this->belongsTo(PurchaseReturn::class, 'return_id');
    }

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class);
    }
}
