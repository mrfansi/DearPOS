<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeShift extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'shift_id',
        'shift_date',
        'status',
        'actual_start_time',
        'actual_end_time',
        'notes'
    ];

    protected $casts = [
        'shift_date' => 'date',
        'actual_start_time' => 'datetime:H:i',
        'actual_end_time' => 'datetime:H:i'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function scopeWorked($query)
    {
        return $query->where('status', 'worked');
    }

    public function scopeAbsent($query)
    {
        return $query->where('status', 'absent');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }
}
