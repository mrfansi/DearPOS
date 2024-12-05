<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductPriceFactory extends Factory
{
    protected $model = ProductPrice::class;

    public function definition(): array
    {
        $priceTypes = ['retail', 'wholesale', 'special'];
        
        return [
            'product_id' => Product::factory(),
            'product_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'currency_id' => Currency::factory(),
            'price_type' => fake()->randomElement($priceTypes),
            'price' => fake()->randomFloat(4, 0.1, 10000),
            'min_quantity' => fake()->randomFloat(4, 1, 100),
            'start_date' => fake()->optional()->date(),
            'end_date' => fake()->optional()->date(),
        ];
    }

    public function retail(): static
    {
        return $this->state(fn (array $attributes) => [
            'price_type' => 'retail',
        ]);
    }

    public function wholesale(): static
    {
        return $this->state(fn (array $attributes) => [
            'price_type' => 'wholesale',
        ]);
    }

    public function special(): static
    {
        return $this->state(fn (array $attributes) => [
            'price_type' => 'special',
            'start_date' => fake()->dateTimeBetween('now', '+1 month'),
            'end_date' => fake()->dateTimeBetween('+1 month', '+2 months'),
        ]);
    }
}
