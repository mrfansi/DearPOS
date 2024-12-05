<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseReceiptItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'purchase_receipt_id',
        'product_id',
        'quantity',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'integer'
    ];

    public function purchaseReceipt()
    {
        return $this->belongsTo(PurchaseReceipt::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
