<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsReceipt extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'goods_receipts';

    protected $fillable = [
        'purchase_order_id',
        'receipt_number',
        'receipt_date',
        'status',
        'notes',
    ];

    protected $casts = [
        'receipt_date' => 'date',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function items()
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }
}
