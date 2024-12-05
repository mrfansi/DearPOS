<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Currency;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->productName(),
            'sku' => strtoupper(fake()->unique()->bothify('PRD-####-????')),
            'description' => fake()->optional()->paragraph(),
            'category_id' => ProductCategory::factory(),
            'base_currency_id' => Currency::factory(),
            'base_unit_id' => UnitOfMeasure::factory(),
            'is_managed_by_recipe' => fake()->boolean(20),
            'track_expiry' => fake()->boolean(30),
            'track_serial' => fake()->boolean(25),
        ];
    }

    public function managed(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_managed_by_recipe' => true,
        ]);
    }

    public function trackable(): static
    {
        return $this->state(fn (array $attributes) => [
            'track_expiry' => true,
            'track_serial' => true,
        ]);
    }
}
