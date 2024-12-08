<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'user_id',
        'department_id',
        'position_id',
        'employee_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'birth_date',
        'hire_date',
        'contract_start_date',
        'contract_end_date',
        'termination_date',
        'status',
        'emergency_contact_name',
        'emergency_contact_phone',
        'notes',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'hire_date' => 'date',
        'contract_start_date' => 'date',
        'contract_end_date' => 'date',
        'termination_date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function position()
    {
        return $this->belongsTo(JobPosition::class, 'position_id');
    }

    public function managedDepartments()
    {
        return $this->hasMany(Department::class, 'manager_id');
    }

    public function addresses()
    {
        return $this->hasMany(EmployeeAddress::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }

    public function benefits()
    {
        return $this->hasMany(EmployeeBenefit::class);
    }

    public function leaveRequests()
    {
        return $this->hasMany(LeaveRequest::class);
    }

    public function shifts()
    {
        return $this->hasMany(EmployeeShift::class);
    }

    public function performanceReviews()
    {
        return $this->hasMany(PerformanceReview::class);
    }

    public function reviewsGiven()
    {
        return $this->hasMany(PerformanceReview::class, 'reviewer_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
