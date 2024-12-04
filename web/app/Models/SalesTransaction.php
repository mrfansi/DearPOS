<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesTransaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'transaction_number',
        'customer_id',
        'pos_counter_id',
        'user_id', // Cashier
        'transaction_date',
        'status',
        'total_amount',
        'subtotal',
        'tax_amount',
        'discount_amount',
        'payment_status',
        'notes',
        'currency_id',
        'is_void',
        'void_reason',
        'is_reservation',
        'reservation_date',
    ];

    protected $casts = [
        'transaction_date' => 'datetime',
        'reservation_date' => 'datetime',
        'total_amount' => 'decimal:4',
        'subtotal' => 'decimal:4',
        'tax_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'is_void' => 'boolean',
        'is_reservation' => 'boolean',
    ];

    /**
     * Get the customer associated with the transaction
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the POS counter where the transaction occurred
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the cashier who processed the transaction
     */
    public function cashier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the transaction items
     */
    public function items(): HasMany
    {
        return $this->hasMany(TransactionItem::class, 'sales_transaction_id');
    }

    /**
     * Get the payments for this transaction
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class, 'sales_transaction_id');
    }

    /**
     * Get the currency for this transaction
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    /**
     * Scope a query to only include completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope a query to only include void transactions
     */
    public function scopeVoided($query)
    {
        return $query->where('is_void', true);
    }

    /**
     * Check if transaction is fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Calculate total quantity of items
     */
    public function getTotalQuantityAttribute()
    {
        return $this->items->sum('quantity');
    }
}
