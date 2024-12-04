<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftRotation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'department_id',
        'rotation_type', // fixed, rotating, split
        'cycle_days',
        'start_date',
        'is_active',
    ];

    protected $casts = [
        'cycle_days' => 'integer',
        'start_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Get the department for this shift rotation
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    /**
     * Get the shift coverages for this rotation
     */
    public function shiftCoverages(): HasMany
    {
        return $this->hasMany(ShiftCoverage::class, 'shift_rotation_id');
    }
}
