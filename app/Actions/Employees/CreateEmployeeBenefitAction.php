<?php

namespace App\Actions\Employees;

use App\Models\EmployeeBenefit;
use Illuminate\Support\Str;

class CreateEmployeeBenefitAction
{
    public function execute(array $data): EmployeeBenefit
    {
        return EmployeeBenefit::create([
            'id' => Str::uuid(),
            'employee_id' => $data['employee_id'],
            'benefit_type' => $data['benefit_type'],
            'provider_name' => $data['provider_name'],
            'coverage_details' => $data['coverage_details'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'] ?? null,
            'annual_cost' => $data['annual_cost'],
            'employee_contribution' => $data['employee_contribution'],
            'employer_contribution' => $data['employer_contribution'],
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 