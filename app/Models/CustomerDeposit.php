<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerDeposit extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'customer_id',
        'amount',
        'used_amount',
        'remaining_amount',
        'deposit_date',
        'expiry_date',
        'notes',
        'status',
    ];

    protected $casts = [
        'amount' => 'decimal:4',
        'used_amount' => 'decimal:4',
        'remaining_amount' => 'decimal:4',
        'deposit_date' => 'date',
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function isExpired(): bool
    {
        return $this->status === 'expired' || 
               ($this->expiry_date && now()->isAfter($this->expiry_date));
    }

    public function updateRemainingAmount(float $usedAmount): void
    {
        $this->used_amount += $usedAmount;
        $this->remaining_amount -= $usedAmount;

        if ($this->remaining_amount <= 0) {
            $this->status = 'used';
        }

        $this->save();
    }
}
