<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class ShiftRotation extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'break_start',
        'break_end',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'break_start' => 'datetime:H:i:s',
        'break_end' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employees(): HasMany
    {
        return $this->hasMany(Employee::class);
    }

    public function calculateShiftDuration(): float
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);
        $breakStart = $this->break_start ? Carbon::parse($this->break_start) : null;
        $breakEnd = $this->break_end ? Carbon::parse($this->break_end) : null;

        $totalDuration = $start->diffInMinutes($end);

        if ($breakStart && $breakEnd) {
            $breakDuration = $breakStart->diffInMinutes($breakEnd);
            $totalDuration -= $breakDuration;
        }

        return $totalDuration / 60; // Convert to hours
    }

    public function isOvernight(): bool
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        return $end->isBefore($start);
    }

    public function scopeWithBreak($query)
    {
        return $query->whereNotNull('break_start')->whereNotNull('break_end');
    }

    public function scopeWithoutBreak($query)
    {
        return $query->whereNull('break_start')->whereNull('break_end');
    }
}
