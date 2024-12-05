<?php

namespace Database\Factories;

use App\Models\InventoryValuation;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryValuationFactory extends Factory
{
    protected $model = InventoryValuation::class;

    public function definition(): array
    {
        $methods = ['FIFO', 'LIFO', 'Average'];
        $quantity = fake()->randomFloat(4, 10, 1000);
        $unitCost = fake()->randomFloat(4, 1, 100);
        $totalValue = $quantity * $unitCost;

        return [
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_value' => $totalValue,
            'valuation_date' => fake()->date(),
            'method' => fake()->randomElement($methods),
        ];
    }

    public function fifo(): static
    {
        return $this->state([
            'method' => 'FIFO',
        ]);
    }

    public function lifo(): static
    {
        return $this->state([
            'method' => 'LIFO',
        ]);
    }

    public function average(): static
    {
        return $this->state([
            'method' => 'Average',
        ]);
    }

    public function lowQuantity(): static
    {
        return $this->state([
            'quantity' => fake()->randomFloat(4, 1, 10),
        ]);
    }

    public function highQuantity(): static
    {
        return $this->state([
            'quantity' => fake()->randomFloat(4, 1000, 10000),
        ]);
    }
}
