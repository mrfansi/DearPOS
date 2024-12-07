<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\EmployeeBenefit;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EmployeeBenefitSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        $benefitTypes = [
            'health_insurance' => [
                'name' => 'Company Health Insurance',
                'description' => 'Comprehensive medical coverage for employees',
                'employer_contribution' => 80,
                'employee_contribution' => 20,
                'amount' => 5000000
            ],
            'life_insurance' => [
                'name' => 'Life Insurance Plan',
                'description' => 'Group life insurance with additional benefits',
                'employer_contribution' => 100,
                'employee_contribution' => 0,
                'amount' => 100000000
            ],
            'retirement_plan' => [
                'name' => 'Retirement Savings Plan',
                'description' => 'Pension and retirement savings program',
                'employer_contribution' => 50,
                'employee_contribution' => 50,
                'amount' => 10000000
            ],
            'dental_insurance' => [
                'name' => 'Dental Care Coverage',
                'description' => 'Comprehensive dental insurance',
                'employer_contribution' => 70,
                'employee_contribution' => 30,
                'amount' => 2000000
            ]
        ];

        foreach ($employees as $employee) {
            // Assign 2-3 benefits per employee
            $selectedBenefits = array_rand($benefitTypes, rand(2, 3));

            foreach ((array)$selectedBenefits as $benefitType) {
                $benefitDetails = $benefitTypes[$benefitType];

                EmployeeBenefit::create([
                    'employee_id' => $employee->id,
                    'name' => $benefitDetails['name'],
                    'description' => $benefitDetails['description'],
                    'benefit_type' => $benefitType,
                    'employer_contribution' => $benefitDetails['employer_contribution'],
                    'employee_contribution' => $benefitDetails['employee_contribution'],
                    'effective_date' => Carbon::now()->subMonths(rand(1, 12)),
                    'expiry_date' => Carbon::now()->addYears(rand(1, 3)),
                    'amount' => $benefitDetails['amount'],
                    'is_active' => true
                ]);
            }
        }
    }
}
