<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GoodsReceiptItem extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'goods_receipt_items';

    protected $fillable = [
        'goods_receipt_id',
        'purchase_order_item_id',
        'product_id',
        'quantity',
        'unit_cost',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'unit_cost' => 'decimal:4',
        'total_amount' => 'decimal:4',
    ];

    public function goodsReceipt()
    {
        return $this->belongsTo(GoodsReceipt::class);
    }

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
