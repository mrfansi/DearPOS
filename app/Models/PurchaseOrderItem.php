<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrderItem extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_order_items';

    protected $fillable = [
        'purchase_order_id',
        'product_id',
        'variant_id',
        'quantity',
        'received_quantity',
        'unit_id',
        'unit_price',
        'tax_amount',
        'discount_amount',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'received_quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'total_amount' => 'decimal:4',
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function unit()
    {
        return $this->belongsTo(UnitsOfMeasure::class, 'unit_id');
    }

    public function receiptItems()
    {
        return $this->hasMany(PurchaseReceiptItem::class);
    }

    public function returnItems()
    {
        return $this->hasMany(PurchaseReturnItem::class);
    }

    public function goodsReceiptItems()
    {
        return $this->hasMany(GoodsReceiptItem::class);
    }
}
