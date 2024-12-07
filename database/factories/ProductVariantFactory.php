<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $cost_price = fake()->randomFloat(4, 10, 1000);
        $selling_price = $cost_price * fake()->randomFloat(2, 1.2, 2.0);
        $min_price = $cost_price * 1.1;

        return [
            'product_id' => Product::factory()->variant(),
            'sku' => strtoupper(fake()->unique()->bothify('SKU-????-####')),
            'barcode' => fake()->ean13(),
            'name' => fake()->words(2, true),
            'cost_price' => $cost_price,
            'selling_price' => $selling_price,
            'min_price' => $min_price,
            'weight' => fake()->randomFloat(4, 0.1, 100),
            'length' => fake()->randomFloat(4, 1, 200),
            'width' => fake()->randomFloat(4, 1, 200),
            'height' => fake()->randomFloat(4, 1, 200),
            'is_active' => fake()->boolean(80),
        ];
    }

    /**
     * Indicate that the variant is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => true,
        ]);
    }
}
