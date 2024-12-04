<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'order_id',
        'driver_id',
        'delivery_address',
        'delivery_fee',
        'estimated_time',
        'actual_time',
        'status',
        'notes'
    ];

    protected $casts = [
        'delivery_fee' => 'decimal:2',
        'estimated_time' => 'datetime',
        'actual_time' => 'datetime'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'order_id');
    }

    public function driver(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'driver_id');
    }
} 