<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductRecipe;
use App\Models\ProductVariant;
use App\Models\RecipeItem;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeItemFactory extends Factory
{
    protected $model = RecipeItem::class;

    public function definition(): array
    {
        return [
            'recipe_id' => ProductRecipe::factory(),
            'ingredient_product_id' => Product::factory(),
            'ingredient_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'quantity' => fake()->randomFloat(4, 0.1, 100),
            'unit_id' => UnitOfMeasure::factory(),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function withQuantity(float $quantity): static
    {
        return $this->state([
            'quantity' => $quantity,
        ]);
    }

    public function withNotes(string $notes): static
    {
        return $this->state([
            'notes' => $notes,
        ]);
    }
}
