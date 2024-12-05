<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DownPaymentConfig extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'minimum_amount',
        'maximum_amount',
        'percentage',
        'is_active',
    ];

    protected $casts = [
        'minimum_amount' => 'decimal:4',
        'maximum_amount' => 'decimal:4',
        'percentage' => 'decimal:2',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
