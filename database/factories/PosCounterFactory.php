<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\PosCounter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PosCounter>
 */
class PosCounterFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PosCounter::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => 'COUNTER-'.fake()->unique()->numberBetween(1, 99),
            'name' => fake()->randomElement([
                'Main Counter',
                'Front Desk',
                'Cashier',
                'Express Checkout',
                'Customer Service Desk',
            ]).' '.fake()->city(),
            'location_id' => Location::factory(),
            'is_active' => fake()->boolean(80), // 80% chance of being active
        ];
    }

    /**
     * Indicate that the counter is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the counter is inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
