<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBenefit extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'benefit_type', // health_insurance, dental, vision, life_insurance, retirement_plan
        'provider_name',
        'coverage_details',
        'start_date',
        'end_date',
        'annual_cost',
        'employee_contribution',
        'employer_contribution',
        'is_active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'annual_cost' => 'decimal:2',
        'employee_contribution' => 'decimal:2',
        'employer_contribution' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the employee associated with this benefit
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
