<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class KitchenOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'order_id',
        'station_id',
        'priority',
        'status',
        'preparation_time',
        'notes'
    ];

    protected $casts = [
        'preparation_time' => 'datetime',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'order_id');
    }

    public function cookingTimes(): HasMany
    {
        return $this->hasMany(CookingTime::class);
    }
} 