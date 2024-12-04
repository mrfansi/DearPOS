<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'employee_number',
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'birth_date',
        'gender',
        'department_id',
        'position_id',
        'hire_date',
        'employment_status',
        'resignation_date',
        'notes'
    ];

    protected $casts = [
        'id' => 'string',
        'birth_date' => 'date',
        'hire_date' => 'date',
        'resignation_date' => 'date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid();
            }

            // Generate employee number if not provided
            if (empty($model->employee_number)) {
                $model->employee_number = $model->generateEmployeeNumber();
            }
        });
    }

    public function generateEmployeeNumber()
    {
        $prefix = 'EMP';
        $latestEmployee = self::withTrashed()
            ->orderBy('created_at', 'desc')
            ->first();

        $lastNumber = $latestEmployee ? intval(substr($latestEmployee->employee_number, -6)) : 0;
        $newNumber = $lastNumber + 1;

        return $prefix . date('Ym') . str_pad($newNumber, 6, '0', STR_PAD_LEFT);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }

    public function fullName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }

    public function attendanceRecords()
    {
        return $this->hasMany(Attendance::class, 'employee_id');
    }

    public function payrollRecords()
    {
        return $this->hasMany(Payroll::class, 'employee_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class, 'employee_id');
    }
}
