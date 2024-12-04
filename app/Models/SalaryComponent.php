<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalaryComponent extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $fillable = [
        'name', // base_salary, bonus, overtime, allowance
        'type', // fixed, variable
        'calculation_type', // percentage, fixed_amount
        'description',
        'is_taxable',
        'is_active',
    ];

    protected $casts = [
        'is_taxable' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the payroll entries for this salary component
     */
    public function payrollEntries(): HasMany
    {
        return $this->hasMany(Payroll::class, 'salary_component_id');
    }
}
