<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'reservation_number',
        'customer_id',
        'pos_counter_id',
        'sales_transaction_id',
        'reservation_date',
        'reservation_time',
        'expected_duration',
        'status',
        'total_guests',
        'special_requests',
        'deposit_amount',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'reservation_date' => 'date',
        'reservation_time' => 'datetime',
        'expected_duration' => 'integer',
        'total_guests' => 'integer',
        'deposit_amount' => 'decimal:4',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function posCounter(): BelongsTo
    {
        return $this->belongsTo(PosCounter::class);
    }

    public function salesTransaction(): BelongsTo
    {
        return $this->belongsTo(SalesTransaction::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }
}
