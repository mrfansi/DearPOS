<?php

namespace Database\Factories;

use App\Models\ProductPriceList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPriceList>
 */
class ProductPriceListFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductPriceList::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->words(3, true),
            'description' => fake()->paragraph(),
            'is_active' => fake()->boolean(80),
            'start_date' => fake()->dateTimeBetween('now', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+2 months', '+6 months'),
        ];
    }

    /**
     * Indicate that the price list is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }

    /**
     * Indicate that the price list is current.
     */
    public function current(): static
    {
        return $this->state(fn (array $attributes) => [
            'start_date' => now(),
            'end_date' => now()->addMonths(3),
            'is_active' => true,
        ]);
    }
}
