<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductMovement;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductMovementFactory extends Factory
{
    protected $model = ProductMovement::class;

    public function definition(): array
    {
        return [
            'movement_type' => $this->faker->word(),
            'quantity' => $this->faker->randomNumber(),
            'reference_type' => $this->faker->word(),
            'reference_id' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Product::factory(),
        ];
    }
}
