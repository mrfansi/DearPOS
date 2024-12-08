<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeBenefit;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeBenefitFactory extends Factory
{
    protected $model = EmployeeBenefit::class;

    public function definition(): array
    {
        $benefitTypes = ['health', 'dental', 'vision', 'life_insurance', 'retirement', 'other'];

        return [
            'employee_id' => Employee::factory(),
            'benefit_name' => $this->faker->randomElement([
                'Basic Health Plan',
                'Premium Health Coverage',
                'Dental Care',
                'Vision Care',
                'Life Insurance',
                'Retirement Savings Plan',
            ]),
            'description' => $this->faker->optional()->paragraph,
            'benefit_type' => $benefitType = $this->faker->randomElement($benefitTypes),
            'employer_contribution' => $this->calculateContribution($benefitType),
            'employee_contribution' => $this->calculateContribution($benefitType, false),
            'effective_date' => $effectiveDate = $this->faker->dateTimeBetween('-1 year', 'now'),
            'expiry_date' => $this->faker->optional()->dateTimeBetween($effectiveDate, '+3 years'),
            'is_active' => $this->faker->boolean(90),
        ];
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id,
        ]);
    }

    public function health()
    {
        return $this->state([
            'benefit_type' => 'health',
            'benefit_name' => 'Comprehensive Health Plan',
        ]);
    }

    public function retirement()
    {
        return $this->state([
            'benefit_type' => 'retirement',
            'benefit_name' => '401(k) Retirement Savings',
        ]);
    }

    private function calculateContribution($benefitType, $isEmployer = true)
    {
        return match ($benefitType) {
            'health' => $isEmployer
                ? $this->faker->randomFloat(2, 100, 500)
                : $this->faker->randomFloat(2, 50, 200),
            'dental' => $isEmployer
                ? $this->faker->randomFloat(2, 50, 200)
                : $this->faker->randomFloat(2, 20, 100),
            'vision' => $isEmployer
                ? $this->faker->randomFloat(2, 25, 100)
                : $this->faker->randomFloat(2, 10, 50),
            'life_insurance' => $isEmployer
                ? $this->faker->randomFloat(2, 50, 300)
                : $this->faker->randomFloat(2, 10, 50),
            'retirement' => $isEmployer
                ? $this->faker->randomFloat(2, 500, 2000)
                : $this->faker->randomFloat(2, 100, 500),
            default => $this->faker->randomFloat(2, 50, 200)
        };
    }
}
