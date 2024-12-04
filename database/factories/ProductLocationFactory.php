<?php

namespace Database\Factories;

use App\Models\ProductLocation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'product_id' => $this->faker->optional()->uuid,
            'variant_id' => $this->faker->optional()->uuid,
            'location_id' => $this->faker->optional()->uuid,
            'quantity' => $this->faker->randomFloat(4, 0, 1000),
            'unit_id' => $this->faker->optional()->uuid,
            'min_stock_level' => $this->faker->randomFloat(4, 0, 100),
            'max_stock_level' => $this->faker->randomFloat(4, 100, 1000),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
