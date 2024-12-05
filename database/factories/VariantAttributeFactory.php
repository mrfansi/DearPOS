<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\VariantAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

class VariantAttributeFactory extends Factory
{
    protected $model = VariantAttribute::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'attribute_id' => ProductAttribute::factory(),
            'is_required' => fake()->boolean(30),
        ];
    }

    public function required(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_required' => true,
        ]);
    }
}
