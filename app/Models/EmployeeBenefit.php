<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBenefit extends Model
{
    use HasUuids, SoftDeletes, HasFactory;

    protected $fillable = [
        'employee_id',
        'benefit_name',
        'description',
        'benefit_type',
        'employer_contribution',
        'employee_contribution',
        'effective_date',
        'expiry_date',
        'is_active'
    ];

    protected $casts = [
        'employer_contribution' => 'decimal:2',
        'employee_contribution' => 'decimal:2',
        'effective_date' => 'date',
        'expiry_date' => 'date',
        'is_active' => 'boolean'
    ];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function isActive()
    {
        return $this->is_active &&
            now()->gte($this->effective_date) &&
            (!$this->expiry_date || now()->lte($this->expiry_date));
    }
}
