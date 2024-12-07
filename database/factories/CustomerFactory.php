<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'group_id' => CustomerGroup::factory(),
            'code' => strtoupper(fake()->unique()->lexify('CUST-????')),
            'name' => fake()->company(),
            'email' => fake()->unique()->companyEmail(),
            'phone' => fake()->phoneNumber(),
            'mobile' => fake()->phoneNumber(),
            'tax_number' => fake()->optional(0.7)->numerify('TAX-########'),
            'credit_limit' => fake()->randomFloat(4, 0, 100000),
            'current_balance' => 0,
            'notes' => fake()->optional(0.3)->sentence(),
            'status' => fake()->randomElement(['active', 'inactive', 'blocked']),
        ];
    }

    /**
     * Indicate that the customer is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the customer is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'inactive',
        ]);
    }

    /**
     * Indicate that the customer is blocked.
     */
    public function blocked(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'blocked',
        ]);
    }

    /**
     * Set the customer's group.
     */
    public function inGroup(CustomerGroup $group): static
    {
        return $this->state(fn (array $attributes) => [
            'group_id' => $group->id,
        ]);
    }
}
