<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'name',
        'start_time',
        'end_time',
        'duration_minutes',
        'description',
        'is_night_shift',
        'is_active'
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time' => 'datetime:H:i',
        'duration_minutes' => 'integer',
        'is_night_shift' => 'boolean',
        'is_active' => 'boolean'
    ];

    public function employeeShifts()
    {
        return $this->hasMany(EmployeeShift::class);
    }

    public function calculateDuration()
    {
        $start = Carbon::parse($this->start_time);
        $end = Carbon::parse($this->end_time);

        // Handle shifts that cross midnight
        if ($end < $start) {
            $end->addDay();
        }

        return $end->diffInMinutes($start);
    }
}
