<?php

namespace Database\Factories;

use App\Models\CustomerAudit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerAudit>
 */
class CustomerAuditFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auditable_type' => fake()->randomElement([
                'App\Models\Customer',
                'App\Models\CustomerGroup',
                'App\Models\CustomerAddress',
                'App\Models\CustomerContact',
            ]),
            'auditable_id' => fake()->uuid(),
            'event' => fake()->randomElement([
                'created',
                'updated',
                'deleted',
                'status_changed',
                'credit_changed',
            ]),
            'old_values' => fake()->optional(0.7, function () {
                return json_encode([
                    'name' => fake()->name(),
                    'status' => fake()->randomElement(['active', 'inactive']),
                    'credit_limit' => fake()->randomFloat(2, 0, 10000),
                ]);
            }),
            'new_values' => fake()->optional(0.7, function () {
                return json_encode([
                    'name' => fake()->name(),
                    'status' => fake()->randomElement(['active', 'inactive']),
                    'credit_limit' => fake()->randomFloat(2, 0, 10000),
                ]);
            }),
            'user_id' => User::factory(),
            'created_at' => fake()->dateTimeThisYear(),
        ];
    }

    /**
     * Set the auditable model.
     */
    public function forModel(string $type, string $id): static
    {
        return $this->state(fn (array $attributes) => [
            'auditable_type' => $type,
            'auditable_id' => $id,
        ]);
    }

    /**
     * Set the event type.
     */
    public function withEvent(string $event): static
    {
        return $this->state(fn (array $attributes) => [
            'event' => $event,
        ]);
    }
}
