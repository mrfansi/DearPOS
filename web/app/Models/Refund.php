<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Refund extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'sales_transaction_id',
        'payment_id',
        'refund_number',
        'total_refund_amount',
        'reason',
        'status', // pending, processed, rejected
        'refund_method', // original_payment, store_credit, cash
        'processed_by',
        'processed_at',
        'notes',
    ];

    protected $casts = [
        'total_refund_amount' => 'decimal:4',
        'processed_at' => 'datetime',
    ];

    /**
     * Get the original sales transaction
     */
    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    /**
     * Get the original payment
     */
    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    /**
     * Get the user who processed the refund
     */
    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    /**
     * Get refund items
     */
    public function refundItems(): HasMany
    {
        return $this->hasMany(RefundItem::class, 'refund_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if refund is processed
     */
    public function isProcessed(): bool
    {
        return $this->status === 'processed';
    }

    /**
     * Calculate total refunded quantity
     */
    public function getTotalRefundedQuantityAttribute()
    {
        return $this->refundItems->sum('quantity');
    }
}
