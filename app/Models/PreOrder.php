<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PreOrder extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'pre_order_number',
        'customer_id',
        'pos_counter_id',
        'sales_transaction_id',
        'order_date',
        'expected_delivery_date',
        'status', // pending, confirmed, processing, completed, cancelled
        'total_amount',
        'deposit_amount',
        'payment_status', // unpaid, partial, paid
        'notes',
        'created_by',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery_date' => 'date',
        'total_amount' => 'decimal:4',
        'deposit_amount' => 'decimal:4',
    ];

    /**
     * Get the customer associated with the pre-order
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the POS counter where the pre-order was made
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the user who created the pre-order
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get pre-order items
     */
    public function preOrderItems(): HasMany
    {
        return $this->hasMany(PreOrderItem::class, 'pre_order_id');
    }

    /**
     * Get associated sales transaction
     */
    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if pre-order is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['pending', 'confirmed', 'processing']);
    }

    /**
     * Calculate total pre-order items
     */
    public function getTotalItemsAttribute()
    {
        return $this->preOrderItems->sum('quantity');
    }

    /**
     * Check if pre-order is fully paid
     */
    public function isFullyPaid(): bool
    {
        return $this->payment_status === 'paid';
    }
}
