<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerAddress>
 */
class CustomerAddressFactory extends Factory
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
            'address_type' => fake()->randomElement(['billing', 'shipping', 'both']),
            'address_line_1' => fake()->streetAddress(),
            'address_line_2' => fake()->optional(0.3)->secondaryAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'postal_code' => fake()->postcode(),
            'country' => fake()->country(),
            'is_default' => fake()->boolean(20),
        ];
    }

    /**
     * Indicate that the address is for billing.
     */
    public function billing(): static
    {
        return $this->state(fn (array $attributes) => [
            'address_type' => 'billing',
        ]);
    }

    /**
     * Indicate that the address is for shipping.
     */
    public function shipping(): static
    {
        return $this->state(fn (array $attributes) => [
            'address_type' => 'shipping',
        ]);
    }

    /**
     * Indicate that the address is for both billing and shipping.
     */
    public function both(): static
    {
        return $this->state(fn (array $attributes) => [
            'address_type' => 'both',
        ]);
    }

    /**
     * Indicate that the address is the default.
     */
    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
        ]);
    }
}
