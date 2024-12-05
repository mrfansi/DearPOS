<?php

namespace Database\Factories;

use App\Models\Location;
use App\Models\Product;
use App\Models\ProductLocation;
use App\Models\ProductVariant;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductLocationFactory extends Factory
{
    protected $model = ProductLocation::class;

    public function definition(): array
    {
        $maxStock = fake()->randomFloat(4, 100, 1000);
        $minStock = fake()->randomFloat(4, 10, $maxStock / 2);
        $quantity = fake()->randomFloat(4, $minStock, $maxStock);
        
        return [
            'product_id' => Product::factory(),
            'variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'location_id' => Location::factory(),
            'quantity' => $quantity,
            'unit_id' => UnitOfMeasure::factory(),
            'min_stock_level' => $minStock,
            'max_stock_level' => $maxStock,
        ];
    }

    public function optimal(): static
    {
        return $this->state(function (array $attributes) {
            $maxStock = fake()->randomFloat(4, 500, 1000);
            $minStock = fake()->randomFloat(4, 100, 200);
            $quantity = fake()->randomFloat(4, 300, 400);
            
            return [
                'quantity' => $quantity,
                'min_stock_level' => $minStock,
                'max_stock_level' => $maxStock,
            ];
        });
    }

    public function needsRestock(): static
    {
        return $this->state(function (array $attributes) {
            $maxStock = fake()->randomFloat(4, 500, 1000);
            $minStock = fake()->randomFloat(4, 100, 200);
            $quantity = fake()->randomFloat(4, 0, $minStock);
            
            return [
                'quantity' => $quantity,
                'min_stock_level' => $minStock,
                'max_stock_level' => $maxStock,
            ];
        });
    }
}
