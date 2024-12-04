<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->word,
            'sku' => strtoupper($this->faker->unique()->lexify('?????')),
            'description' => $this->faker->sentence,
            'category_id' => $this->faker->optional()->uuid,
            'base_currency_id' => $this->faker->optional()->uuid,
            'base_unit_id' => $this->faker->optional()->uuid,
            'is_managed_by_recipe' => $this->faker->boolean,
            'track_expiry' => $this->faker->boolean,
            'track_serial' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
