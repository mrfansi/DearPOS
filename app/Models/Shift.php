<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name',
        'code',
        'start_time',
        'end_time',
        'break_duration',
        'is_overnight',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'break_duration' => 'integer',
        'is_overnight' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Relationships
    public function employeeShifts()
    {
        return $this->hasMany(EmployeeShift::class);
    }

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_shifts')
            ->withPivot(['date', 'actual_start', 'actual_end', 'status', 'notes'])
            ->withTimestamps();
    }
}
