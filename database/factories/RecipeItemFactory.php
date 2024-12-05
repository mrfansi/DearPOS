<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductRecipe;
use App\Models\RecipeItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class RecipeItemFactory extends Factory
{
    protected $model = RecipeItem::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomFloat(),
            'unit' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'recipe_id' => ProductRecipe::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
