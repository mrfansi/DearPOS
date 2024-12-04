<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShiftCoverage extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'shift_rotation_id',
        'employee_id',
        'date',
        'shift_id',
        'is_primary',
        'is_replacement',
        'replacement_employee_id',
        'reason_for_coverage',
    ];

    protected $casts = [
        'date' => 'date',
        'is_primary' => 'boolean',
        'is_replacement' => 'boolean',
    ];

    /**
     * Get the shift rotation
     */
    public function shiftRotation(): BelongsTo
    {
        return $this->belongsTo(ShiftRotation::class, 'shift_rotation_id');
    }

    /**
     * Get the primary employee
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    /**
     * Get the shift
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    /**
     * Get the replacement employee
     */
    public function replacementEmployee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'replacement_employee_id');
    }
}
