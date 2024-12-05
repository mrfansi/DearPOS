<?php

namespace Database\Factories;

use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantValueFactory extends Factory
{
    protected $model = ProductVariantValue::class;

    public function definition(): array
    {
        return [
            'variant_id' => ProductVariant::factory(),
            'attribute_id' => ProductAttribute::factory(),
            'value' => fake()->word(),
        ];
    }
}
