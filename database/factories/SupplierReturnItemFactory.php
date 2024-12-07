<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SupplierReturn;
use App\Models\SupplierReturnItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierReturnItemFactory extends Factory
{
    protected $model = SupplierReturnItem::class;

    public function definition(): array
    {
        $quantity = $this->faker->randomFloat(4, 1, 50);
        $unitCost = $this->faker->randomFloat(4, 1, 500);
        $totalAmount = $quantity * $unitCost;

        return [
            'supplier_return_id' => SupplierReturn::factory(),
            'product_id' => Product::factory(),
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_amount' => $totalAmount,
            'reason' => $this->faker->optional()->sentence()
        ];
    }
};
