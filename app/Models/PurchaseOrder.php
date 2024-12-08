<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_orders';

    protected $fillable = [
        'order_number',
        'supplier_id',
        'warehouse_id',
        'currency_id',
        'status',
        'order_date',
        'expected_date',
        'total_amount',
        'tax_amount',
        'discount_amount',
        'shipping_amount',
        'grand_total',
        'notes',
        'created_by',
        'approved_by',
        'approved_at',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_date' => 'date',
        'total_amount' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'shipping_amount' => 'decimal:4',
        'grand_total' => 'decimal:4',
        'approved_at' => 'datetime',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    public function receipts()
    {
        return $this->hasMany(PurchaseReceipt::class);
    }

    public function returns()
    {
        return $this->hasMany(PurchaseReturn::class);
    }

    public function goodsReceipts()
    {
        return $this->hasMany(GoodsReceipt::class);
    }
}
