<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class QueueManagement extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'queue_number',
        'customer_id',
        'pos_counter_id',
        'status', // waiting, processing, completed, cancelled
        'priority',
        'estimated_wait_time',
        'actual_wait_time',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'estimated_wait_time' => 'integer', // in minutes
        'actual_wait_time' => 'integer', // in minutes
        'priority' => 'integer',
    ];

    /**
     * Get the customer associated with the queue
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the POS counter where the queue was created
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the user who created the queue entry
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get queue items
     */
    public function queueItems(): HasMany
    {
        return $this->hasMany(QueueItem::class, 'queue_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if queue is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['waiting', 'processing']);
    }

    /**
     * Calculate total queue items
     */
    public function getTotalItemsAttribute()
    {
        return $this->queueItems->sum('quantity');
    }
}
