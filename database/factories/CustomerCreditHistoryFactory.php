<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerCreditHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerCreditHistory>
 */
class CustomerCreditHistoryFactory extends Factory
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
            'transaction_type' => fake()->randomElement(['increase', 'decrease', 'adjustment']),
            'amount' => fake()->randomFloat(4, 10, 10000),
            'reference_type' => fake()->randomElement(['sales_order', 'payment', 'credit_note', 'manual']),
            'reference_id' => fake()->optional(0.7)->uuid(),
            'notes' => fake()->optional(0.5)->sentence(),
            'created_by' => User::factory(),
        ];
    }

    /**
     * Indicate that the transaction is an increase.
     */
    public function increase(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'increase',
        ]);
    }

    /**
     * Indicate that the transaction is a decrease.
     */
    public function decrease(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'decrease',
        ]);
    }

    /**
     * Indicate that the transaction is an adjustment.
     */
    public function adjustment(): static
    {
        return $this->state(fn (array $attributes) => [
            'transaction_type' => 'adjustment',
        ]);
    }

    /**
     * Set the reference type and ID.
     */
    public function withReference(string $type, string $id): static
    {
        return $this->state(fn (array $attributes) => [
            'reference_type' => $type,
            'reference_id' => $id,
        ]);
    }
}
