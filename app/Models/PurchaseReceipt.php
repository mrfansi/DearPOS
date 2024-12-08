<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReceipt extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_receipts';

    protected $fillable = [
        'receipt_number',
        'purchase_order_id',
        'receipt_date',
        'status',
        'notes',
        'received_by',
    ];

    protected $casts = [
        'receipt_date' => 'date',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    public function items()
    {
        return $this->hasMany(PurchaseReceiptItem::class, 'receipt_id');
    }
}
