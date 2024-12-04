<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosShift extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'pos_counter_id',
        'user_id', // Cashier
        'start_time',
        'end_time',
        'status',
        'opening_cash_balance',
        'closing_cash_balance',
        'cash_sales_total',
        'total_transactions',
        'notes',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'opening_cash_balance' => 'decimal:4',
        'closing_cash_balance' => 'decimal:4',
        'cash_sales_total' => 'decimal:4',
    ];

    /**
     * Get the POS counter for this shift
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the cashier for this shift
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the sales transactions during this shift
     */
    public function salesTransactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class, 'pos_shift_id');
    }

    /**
     * Scope a query to only include active shifts
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Check if the shift is open
     */
    public function isOpen(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Calculate total cash transactions
     */
    public function getTotalCashTransactionsAttribute()
    {
        return $this->salesTransactions()
            ->where('payment_status', 'paid')
            ->sum('total_amount');
    }
}
