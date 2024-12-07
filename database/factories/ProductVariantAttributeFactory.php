<?php

namespace Database\Factories;

use App\Models\ProductVariant;
use App\Models\ProductVariantAttribute;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariantAttribute>
 */
class ProductVariantAttributeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariantAttribute::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $attributeIndex = 0;
        $attributes = [
            ['name' => 'Color', 'values' => ['Red', 'Blue', 'Green', 'Black', 'White']],
            ['name' => 'Size', 'values' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']],
            ['name' => 'Material', 'values' => ['Cotton', 'Polyester', 'Leather', 'Wool', 'Silk']],
            ['name' => 'Style', 'values' => ['Casual', 'Formal', 'Sport', 'Classic', 'Modern']],
        ];

        $attribute = $attributes[$attributeIndex % count($attributes)];
        $attributeIndex++;

        return [
            'variant_id' => ProductVariant::factory(),
            'attribute_name' => $attribute['name'],
            'attribute_value' => fake()->randomElement($attribute['values']),
        ];
    }
}
