<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class TableReservation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'reservation_number',
        'customer_id',
        'table_id',
        'branch_id',
        'reservation_date',
        'start_time',
        'end_time',
        'number_of_guests',
        'status', // pending, confirmed, active, completed, cancelled
        'special_requests',
        'deposit_amount',
        'total_expected_spend',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'number_of_guests' => 'integer',
        'deposit_amount' => 'decimal:4',
        'total_expected_spend' => 'decimal:4',
    ];

    /**
     * Get the customer who made the reservation
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    /**
     * Get the reserved table
     */
    public function table(): BelongsTo
    {
        return $this->belongsTo(Table::class, 'table_id');
    }

    /**
     * Get the branch where the reservation is made
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get the user who created the reservation
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get reservation items (optional)
     */
    public function reservationItems(): HasMany
    {
        return $this->hasMany(ReservationItem::class, 'reservation_id');
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if reservation is currently active
     */
    public function isActive(): bool
    {
        $now = now();
        return $this->status === 'active' 
            && $this->reservation_date->isToday()
            && $now->between($this->start_time, $this->end_time);
    }

    /**
     * Check if reservation is confirmed but not yet started
     */
    public function isConfirmed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Calculate reservation duration in hours
     */
    public function getDurationAttribute()
    {
        return $this->start_time->diffInHours($this->end_time);
    }

    /**
     * Check if deposit is paid
     */
    public function isDepositPaid(): bool
    {
        return $this->deposit_amount > 0;
    }
}
