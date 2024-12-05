<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'date',
        'clock_in',
        'clock_out',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'clock_in' => 'datetime:H:i:s',
        'clock_out' => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function scopePresent($query)
    {
        return $query->where('status', 'present');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    public function scopeEarlyLeave($query)
    {
        return $query->where('status', 'early_leave');
    }

    public function calculateWorkDuration(): ?float
    {
        if (!$this->clock_in || !$this->clock_out) {
            return null;
        }

        $clockIn = Carbon::parse($this->clock_in);
        $clockOut = Carbon::parse($this->clock_out);

        return $clockIn->diffInHours($clockOut);
    }

    public function isLate(Carbon $expectedClockInTime): bool
    {
        if (!$this->clock_in) {
            return false;
        }

        $actualClockIn = Carbon::parse($this->clock_in);
        return $actualClockIn->greaterThan($expectedClockInTime);
    }

    public function isEarlyLeave(Carbon $expectedClockOutTime): bool
    {
        if (!$this->clock_out) {
            return false;
        }

        $actualClockOut = Carbon::parse($this->clock_out);
        return $actualClockOut->lessThan($expectedClockOutTime);
    }

    public function updateStatus(Carbon $expectedClockInTime = null, Carbon $expectedClockOutTime = null): void
    {
        if (!$this->clock_in && !$this->clock_out) {
            $this->status = 'absent';
        } elseif ($expectedClockInTime && $this->isLate($expectedClockInTime)) {
            $this->status = 'late';
        } elseif ($expectedClockOutTime && $this->isEarlyLeave($expectedClockOutTime)) {
            $this->status = 'early_leave';
        } else {
            $this->status = 'present';
        }

        $this->save();
    }
}
