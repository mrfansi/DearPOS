<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BreakTime extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'shift_id',
        'break_type', // lunch, rest, prayer, etc.
        'start_time',
        'end_time',
        'duration_minutes',
        'is_paid',
        'is_mandatory',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration_minutes' => 'integer',
        'is_paid' => 'boolean',
        'is_mandatory' => 'boolean',
    ];

    /**
     * Get the shift associated with this break time
     */
    public function shift(): BelongsTo
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
