<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductImage>
 */
class ProductImageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductImage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = fake()->uuid().'.jpg';

        return [
            'product_id' => Product::factory(),
            'variant_id' => null,
            'file_name' => $fileName,
            'file_path' => 'products/'.$fileName,
            'file_type' => 'image/jpeg',
            'file_size' => fake()->numberBetween(50000, 5000000),
            'is_primary' => false,
            'sort_order' => fake()->numberBetween(1, 10),
        ];
    }

    /**
     * Indicate that the image belongs to a variant.
     */
    public function forVariant(): static
    {
        return $this->state(function (array $attributes) {
            $variant = ProductVariant::factory()->create();

            return [
                'product_id' => $variant->product_id,
                'variant_id' => $variant->id,
            ];
        });
    }

    /**
     * Indicate that the image is primary.
     */
    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
            'sort_order' => 1,
        ]);
    }
}
