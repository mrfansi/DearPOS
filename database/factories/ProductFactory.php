<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'category_id' => ProductCategory::factory(),
            'brand_id' => ProductBrand::factory(),
            'code' => strtoupper(fake()->unique()->bothify('PRD-????-####')),
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'type' => fake()->randomElement(['simple', 'variant', 'service']),
            'unit_type' => fake()->randomElement(['piece', 'weight', 'length', 'volume', 'time']),
            'tax_type' => fake()->randomElement(['taxable', 'non_taxable']),
            'tax_rate' => function (array $attributes) {
                return $attributes['tax_type'] === 'taxable' ? fake()->randomFloat(2, 0, 20) : 0;
            },
            'notes' => fake()->optional()->paragraph(),
            'status' => fake()->randomElement(['active', 'inactive', 'discontinued']),
        ];
    }

    /**
     * Indicate that the product is active.
     */
    public function active(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'active',
        ]);
    }

    /**
     * Indicate that the product is a variant type.
     */
    public function variant(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'variant',
        ]);
    }
}
