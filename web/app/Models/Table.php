<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Table extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'branch_id',
        'section_id',
        'capacity',
        'table_type', // standard, vip, outdoor, private room
        'status', // available, occupied, reserved, cleaning
        'description',
        'is_active',
        'qr_code_url',
        'floor_number',
        'x_coordinate',
        'y_coordinate',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
        'x_coordinate' => 'decimal:2',
        'y_coordinate' => 'decimal:2',
    ];

    /**
     * Get the branch where the table is located
     */
    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /**
     * Get the section of the table
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    /**
     * Get table reservations
     */
    public function tableReservations(): HasMany
    {
        return $this->hasMany(TableReservation::class, 'table_id');
    }

    /**
     * Get active table reservations
     */
    public function activeReservations(): HasMany
    {
        return $this->tableReservations()
            ->where('status', 'active')
            ->where('reservation_date', '>=', now());
    }

    /**
     * Scope a query to filter by status
     */
    public function scopeOfStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Check if table is currently available
     */
    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->is_active;
    }

    /**
     * Get current reservation (if any)
     */
    public function getCurrentReservationAttribute()
    {
        return $this->tableReservations()
            ->where('status', 'active')
            ->where('reservation_date', '<=', now())
            ->where('end_time', '>=', now())
            ->first();
    }
}
