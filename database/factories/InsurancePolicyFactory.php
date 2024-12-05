<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\InsurancePolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

class InsurancePolicyFactory extends Factory
{
    protected $model = InsurancePolicy::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-1 year', 'now');
        $endDate = fake()->dateTimeBetween($startDate, '+2 years');

        return [
            'employee_id' => Employee::factory(),
            'policy_number' => fake()->unique()->bothify('POL-####-????'),
            'provider' => fake()->company(),
            'type' => fake()->randomElement(['health', 'life', 'accident', 'disability']),
            'coverage_amount' => fake()->randomFloat(4, 10000, 1000000),
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }

    public function health(): static
    {
        return $this->state([
            'type' => 'health',
        ]);
    }

    public function life(): static
    {
        return $this->state([
            'type' => 'life',
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'start_date' => fake()->dateTimeBetween('-2 years', '-1 year'),
            'end_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function active(): static
    {
        return $this->state([
            'start_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'end_date' => fake()->dateTimeBetween('now', '+2 years'),
        ]);
    }
}
