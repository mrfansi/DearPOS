<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReceiptItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_receipt_items';

    protected $fillable = [
        'receipt_id',
        'purchase_order_item_id',
        'quantity_received',
        'lot_number',
        'expiry_date',
        'notes',
    ];

    protected $casts = [
        'quantity_received' => 'decimal:4',
        'expiry_date' => 'date',
    ];

    public function receipt()
    {
        return $this->belongsTo(PurchaseReceipt::class);
    }

    public function purchaseOrderItem()
    {
        return $this->belongsTo(PurchaseOrderItem::class);
    }
}
