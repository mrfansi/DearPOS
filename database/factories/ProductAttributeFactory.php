<?php

namespace Database\Factories;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAttribute::class;

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
            'data_type' => $this->faker->randomElement(['string', 'integer', 'decimal', 'boolean', 'date']),
            'is_required' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
