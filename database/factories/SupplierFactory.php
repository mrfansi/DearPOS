<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{3}'),
            'name' => $this->faker->company(),
            'company_name' => $this->faker->optional()->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'mobile' => $this->faker->optional()->phoneNumber(),
            'website' => $this->faker->optional()->url(),
            'tax_number' => $this->faker->optional()->regexify('[0-9]{10}'),
            'notes' => $this->faker->optional()->paragraph(),
            'status' => $this->faker->randomElement(['active', 'inactive'])
        ];
    }

    public function active()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active'
        ]);
    }

    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive'
        ]);
    }
};
