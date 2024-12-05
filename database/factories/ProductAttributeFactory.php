<?php

namespace Database\Factories;

use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAttributeFactory extends Factory
{
    protected $model = ProductAttribute::class;

    public function definition(): array
    {
        $dataTypes = ['string', 'number', 'boolean', 'date', 'color'];
        
        return [
            'name' => fake()->unique()->words(2, true),
            'data_type' => fake()->randomElement($dataTypes),
            'is_required' => fake()->boolean(30),
        ];
    }
}
