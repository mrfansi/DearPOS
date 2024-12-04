<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Attendance extends Model
{
    use HasUuids, SoftDeletes;

    protected $table = 'attendance';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_id',
        'shift_id',
        'attendance_date',
        'check_in',
        'check_out',
        'status',
        'worked_hours',
        'notes'
    ];

    protected $casts = [
        'id' => 'string',
        'attendance_date' => 'date',
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'worked_hours' => 'decimal:2'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            $model->calculateAttendanceStatus();
            $model->calculateWorkedHours();
        });

        static::updating(function ($model) {
            $model->calculateAttendanceStatus();
            $model->calculateWorkedHours();
        });
    }

    public function calculateAttendanceStatus()
    {
        if (!$this->check_in && !$this->check_out) {
            $this->status = 'absent';
            return;
        }

        $shift = $this->shift;
        $shiftStart = Carbon::parse($shift->start_time);
        $shiftEnd = Carbon::parse($shift->end_time);
        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);

        // Adjust for overnight shifts
        if ($shiftEnd < $shiftStart) {
            $shiftEnd->addDay();
        }

        // Check late arrival
        if ($checkIn > $shiftStart->addMinutes(15)) {
            $this->status = 'late';
        }

        // Check early leave
        if ($checkOut < $shiftEnd->subMinutes(15)) {
            $this->status = 'early_leave';
        }

        // Check half day
        $requiredWorkHours = $shift->working_hours;
        $actualWorkHours = $this->calculateWorkedHours();
        if ($actualWorkHours < ($requiredWorkHours / 2)) {
            $this->status = 'half_day';
        }

        // Default to present if no other status set
        if (!$this->status) {
            $this->status = 'present';
        }
    }

    public function calculateWorkedHours()
    {
        if (!$this->check_in || !$this->check_out) {
            $this->worked_hours = 0;
            return 0;
        }

        $checkIn = Carbon::parse($this->check_in);
        $checkOut = Carbon::parse($this->check_out);

        $workedHours = $checkIn->diffInHours($checkOut, false);
        $this->worked_hours = max(0, $workedHours);

        return $this->worked_hours;
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }
}
