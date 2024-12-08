<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchaseReturn extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'purchase_returns';

    protected $fillable = [
        'return_number',
        'purchase_order_id',
        'supplier_id',
        'return_date',
        'status',
        'reason',
        'total_amount',
        'notes',
        'created_by',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'return_date' => 'date',
        'total_amount' => 'decimal:4',
        'approved_at' => 'datetime'
    ];

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
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
        return $this->hasMany(PurchaseReturnItem::class, 'return_id');
    }
}
