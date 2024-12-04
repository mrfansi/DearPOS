<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CookingTime extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'kitchen_order_id',
        'start_time',
        'end_time',
        'duration',
        'chef_id',
        'notes'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'integer' // in seconds
    ];

    public function kitchenOrder(): BelongsTo
    {
        return $this->belongsTo(KitchenOrder::class);
    }

    public function chef(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'chef_id');
    }
} 