<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductRecipe;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductRecipeFactory extends Factory
{
    protected $model = ProductRecipe::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'name' => fake()->words(3, true),
            'description' => fake()->optional()->paragraph(),
            'output_quantity' => fake()->randomFloat(4, 1, 100),
            'output_unit_id' => UnitOfMeasure::factory(),
            'instructions' => fake()->optional()->paragraphs(3, true),
        ];
    }

    public function withInstructions(): static
    {
        return $this->state([
            'instructions' => fake()->paragraphs(3, true),
        ]);
    }

    public function withOutputQuantity(float $quantity): static
    {
        return $this->state([
            'output_quantity' => $quantity,
        ]);
    }
}
