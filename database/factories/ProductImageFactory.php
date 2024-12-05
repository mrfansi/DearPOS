<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        $imageTypes = ['primary', 'thumbnail', 'gallery'];
        
        return [
            'product_id' => Product::factory(),
            'product_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'image_url' => fake()->imageUrl(640, 480, 'products'),
            'image_type' => fake()->randomElement($imageTypes),
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'image_type' => 'primary',
            'sort_order' => 1,
        ]);
    }

    public function thumbnail(): static
    {
        return $this->state(fn (array $attributes) => [
            'image_type' => 'thumbnail',
            'sort_order' => 2,
        ]);
    }

    public function gallery(): static
    {
        return $this->state(fn (array $attributes) => [
            'image_type' => 'gallery',
            'sort_order' => fake()->numberBetween(3, 100),
        ]);
    }
}
