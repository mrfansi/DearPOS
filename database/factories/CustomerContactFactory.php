<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerContact>
 */
class CustomerContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_id' => Customer::factory(),
            'name' => fake()->name(),
            'position' => fake()->optional(0.8)->jobTitle(),
            'email' => fake()->optional(0.9)->safeEmail(),
            'phone' => fake()->optional(0.7)->phoneNumber(),
            'mobile' => fake()->optional(0.8)->phoneNumber(),
            'is_primary' => fake()->boolean(20),
            'notes' => fake()->optional(0.3)->sentence(),
        ];
    }

    /**
     * Indicate that the contact is primary.
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }

    /**
     * Indicate that the contact is not primary.
     */
    public function notPrimary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => false,
        ]);
    }
}
