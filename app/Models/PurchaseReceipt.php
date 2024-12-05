<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReceipt extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'purchase_order_id',
        'receipt_date',
        'status',
        'notes'
    ];

    protected $casts = [
        'receipt_date' => 'datetime'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function recordReceipt(int $orderId, int $productId, int $quantity): bool
    {
        return $this->items()->create([
                'product_id' => $productId,
                'quantity' => $quantity
            ]) !== null;
    }

    public function items()
    {
        return $this->hasMany(PurchaseReceiptItem::class);
    }
}
