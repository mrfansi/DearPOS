<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'code' => strtoupper(fake()->unique()->bothify('COM-####-??')),
            'address' => fake()->optional()->address(),
            'phone' => fake()->optional()->phoneNumber(),
            'email' => fake()->optional()->companyEmail(),
            'tax_id' => fake()->optional()->numerify('TAX-###-###-###'),
            'primary_currency_id' => Currency::factory(),
            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function withTaxId(): static
    {
        return $this->state([
            'tax_id' => fake()->numerify('TAX-###-###-###'),
        ]);
    }
}
