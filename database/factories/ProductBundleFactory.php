<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductBundle;
use App\Models\ProductVariant;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductBundleFactory extends Factory
{
    protected $model = ProductBundle::class;

    public function definition(): array
    {
        return [
            'bundle_product_id' => Product::factory(),
            'component_product_id' => Product::factory(),
            'component_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'quantity' => fake()->randomFloat(4, 1, 100),
            'unit_id' => UnitOfMeasure::factory(),
        ];
    }

    public function withQuantity(float $quantity): static
    {
        return $this->state([
            'quantity' => $quantity,
        ]);
    }
}
