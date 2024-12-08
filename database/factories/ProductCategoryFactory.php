<?php

namespace Database\Factories;

use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductCategory>
 */
class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'description' => fake()->paragraph(),
            'is_active' => fake()->boolean(80),
            'sort_order' => fake()->numberBetween(1, 100),
        ];
    }

    /**
     * Indicate that the category is a child category.
     */
    public function child(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => ProductCategory::factory(),
            ];
        });
    }
}
