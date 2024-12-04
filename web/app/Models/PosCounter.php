<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PosCounter extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'location_id',
        'is_active',
        'description',
        'terminal_number',
        'printer_name',
        'cash_drawer_name',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the location of the POS counter
     */
    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class, 'location_id');
    }

    /**
     * Get all sales transactions for this POS counter
     */
    public function salesTransactions(): HasMany
    {
        return $this->hasMany(SalesTransaction::class, 'pos_counter_id');
    }

    /**
     * Get all POS shifts for this counter
     */
    public function posShifts(): HasMany
    {
        return $this->hasMany(PosShift::class, 'pos_counter_id');
    }

    /**
     * Scope a query to only include active POS counters
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get the current active shift for this POS counter
     */
    public function getCurrentActiveShiftAttribute()
    {
        return $this->posShifts()->where('status', 'active')->first();
    }
}
