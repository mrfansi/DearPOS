<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ReorderConfig;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReorderConfigFactory extends Factory
{
    protected $model = ReorderConfig::class;

    public function definition(): array
    {
        $minimumQuantity = fake()->randomFloat(4, 10, 100);
        $maximumQuantity = fake()->randomFloat(4, $minimumQuantity, 500);
        $reorderPoint = fake()->randomFloat(4, 5, $minimumQuantity);

        return [
            'product_id' => Product::factory(),
            'minimum_quantity' => $minimumQuantity,
            'maximum_quantity' => $maximumQuantity,
            'reorder_point' => $reorderPoint,
            'is_active' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function lowStock(): static
    {
        return $this->state(function () {
            $minimumQuantity = fake()->randomFloat(4, 10, 50);
            $reorderPoint = fake()->randomFloat(4, 1, $minimumQuantity);

            return [
                'minimum_quantity' => $minimumQuantity,
                'reorder_point' => $reorderPoint,
            ];
        });
    }

    public function highStock(): static
    {
        return $this->state(function () {
            $minimumQuantity = fake()->randomFloat(4, 200, 500);
            $maximumQuantity = fake()->randomFloat(4, $minimumQuantity, 1000);
            $reorderPoint = fake()->randomFloat(4, 100, $minimumQuantity);

            return [
                'minimum_quantity' => $minimumQuantity,
                'maximum_quantity' => $maximumQuantity,
                'reorder_point' => $reorderPoint,
            ];
        });
    }
}
