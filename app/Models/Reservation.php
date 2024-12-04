<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reservation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'reservation_number',
        'customer_id',
        'pos_counter_id',
        'reservation_date',
        'reservation_time',
        'expected_duration',
        'status', // confirmed, in_progress, completed, cancelled
        'total_guests',
        'special_requests',
        'deposit_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime',
        'expected_duration' => 'integer', // in minutes
        'total_guests' => 'integer',
        'deposit_amount' => 'decimal:4',
    ];

    /**
     * Get the customer associated with the reservation
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the POS counter where the reservation was made
     */
    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class, 'pos_counter_id');
    }

    /**
     * Get the user who created the reservation
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get reservation items
     */
    public function reservationItems(): HasMany
    {
        return $this->hasMany(ReservationItem::class, 'reservation_id');
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
     * Check if reservation is active
     */
    public function isActive(): bool
    {
        return in_array($this->status, ['confirmed', 'in_progress']);
    }

    /**
     * Calculate total reservation items
     */
    public function getTotalItemsAttribute()
    {
        return $this->reservationItems->sum('quantity');
    }
}
