<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeShift extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'shift_id',
        'date',
        'actual_start',
        'actual_end',
        'status',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
        'actual_start' => 'datetime',
        'actual_end' => 'datetime',
    ];

    // Relationships
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
