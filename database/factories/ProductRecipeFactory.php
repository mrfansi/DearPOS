<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductRecipe;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductRecipeFactory extends Factory
{
    protected $model = ProductRecipe::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'instructions' => $this->faker->word(),
            'yield_quantity' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Product::factory(),
        ];
    }
}
