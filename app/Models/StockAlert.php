<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockAlert extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'warehouse_id',
        'alert_type',
        'threshold_quantity',
        'current_quantity',
        'status',
        'is_notification_sent',
        'notification_date',
        'resolved_by',
        'resolved_at',
        'notes',
    ];

    protected $casts = [
        'threshold_quantity' => 'decimal:4',
        'current_quantity' => 'decimal:4',
        'is_notification_sent' => 'boolean',
        'notification_date' => 'datetime',
        'resolved_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
