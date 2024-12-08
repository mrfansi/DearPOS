<?php

namespace Database\Factories;

use App\Models\SupplierCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierCategoryFactory extends Factory
{
    protected $model = SupplierCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'description' => $this->faker->optional()->sentence(),
            'is_active' => $this->faker->boolean(80),
        ];
    }

    public function inactive()
    {
        return $this->state(fn (array $attributes) => [
            'is_active' => false,
        ]);
    }
}
