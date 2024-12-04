<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableTransfer extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'from_table_id',
        'to_table_id',
        'sales_transaction_id',
        'user_id', // staff who performed the transfer
        'transfer_reason',
        'status', // pending, completed, cancelled
        'notes',
    ];

    /**
     * Get the source table
     */
    public function fromTable(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'from_table_id');
    }

    /**
     * Get the destination table
     */
    public function toTable(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'to_table_id');
    }

    /**
     * Get the associated sales transaction
     */
    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class, 'sales_transaction_id');
    }

    /**
     * Get the user who performed the transfer
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
     * Check if table transfer is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }
}
