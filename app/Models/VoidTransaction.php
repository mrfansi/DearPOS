<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VoidTransaction extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'sales_transaction_id',
        'pos_counter_id',
        'user_id', // staff who voided the transaction
        'void_reason',
        'status', // pending, approved, rejected
        'original_total_amount',
        'notes',
    ];

    protected $casts = [
        'original_total_amount' => 'decimal:4',
    ];

    /**
     * Get the original sales transaction
     */
    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    /**
     * Get the POS counter
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the user who voided the transaction
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if void transaction is approved
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}
