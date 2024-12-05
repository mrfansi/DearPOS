<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ProductVariant;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductInventoryFactory extends Factory
{
    protected $model = ProductInventory::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(4, 0, 1000);
        $reserved = fake()->randomFloat(4, 0, $quantity);
        
        return [
            'product_id' => Product::factory(),
            'product_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'warehouse_id' => Warehouse::factory(),
            'quantity' => $quantity,
            'reserved_quantity' => $reserved,
            'available_quantity' => $quantity - $reserved,
        ];
    }

    public function inStock(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = fake()->randomFloat(4, 100, 1000);
            $reserved = fake()->randomFloat(4, 0, $quantity / 2);
            
            return [
                'quantity' => $quantity,
                'reserved_quantity' => $reserved,
                'available_quantity' => $quantity - $reserved,
            ];
        });
    }

    public function lowStock(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = fake()->randomFloat(4, 1, 10);
            $reserved = fake()->randomFloat(4, 0, $quantity / 2);
            
            return [
                'quantity' => $quantity,
                'reserved_quantity' => $reserved,
                'available_quantity' => $quantity - $reserved,
            ];
        });
    }

    public function outOfStock(): static
    {
        return $this->state([
            'quantity' => 0,
            'reserved_quantity' => 0,
            'available_quantity' => 0,
        ]);
    }
}
