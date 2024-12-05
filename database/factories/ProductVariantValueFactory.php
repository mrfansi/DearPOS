<?php

namespace Database\Factories;

use App\Models\ProductAttribute;
use App\Models\ProductVariant;
use App\Models\ProductVariantValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductVariantValueFactory extends Factory
{
    protected $model = ProductVariantValue::class;

    public function definition(): array
    {
        return [
            'value' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'variant_id' => ProductVariant::factory(),
            'attribute_id' => ProductAttribute::factory(),
        ];
    }
}
