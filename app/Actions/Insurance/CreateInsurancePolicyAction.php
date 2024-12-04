<?php

namespace App\Actions\Insurance;

use App\Models\InsurancePolicy;
use Illuminate\Support\Str;

class CreateInsurancePolicyAction
{
    public function execute(array $data): InsurancePolicy
    {
        return InsurancePolicy::create([
            'id' => Str::uuid(),
            'employee_id' => $data['employee_id'],
            'policy_type' => $data['policy_type'],
            'provider_name' => $data['provider_name'],
            'policy_number' => $data['policy_number'],
            'coverage_amount' => $data['coverage_amount'],
            'premium_amount' => $data['premium_amount'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'coverage_details' => $data['coverage_details'] ?? null,
            'beneficiary_name' => $data['beneficiary_name'] ?? null,
            'beneficiary_relationship' => $data['beneficiary_relationship'] ?? null,
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 