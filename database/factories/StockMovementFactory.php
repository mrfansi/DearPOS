<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\StockMovement;
use App\Models\UnitOfMeasure;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockMovementFactory extends Factory
{
    protected $model = StockMovement::class;

    public function definition(): array
    {
        $product = Product::factory()->create();
        $warehouse = Warehouse::factory()->create();
        $unit = UnitOfMeasure::factory()->create();
        $user = User::factory()->create();

        return [
            'product_id' => $product->id,
            'product_variant_id' => $this->faker->boolean(30) ? ProductVariant::factory()->create(['product_id' => $product->id])->id : null,
            'warehouse_id' => $warehouse->id,
            'movement_type' => $this->faker->randomElement(['in', 'out', 'transfer', 'adjustment']),
            'quantity' => $this->faker->randomFloat(4, 1, 1000),
            'unit_id' => $unit->id,
            'reference_type' => $this->faker->randomElement(['sale', 'purchase', 'transfer', 'adjustment', 'waste']),
            'reference_id' => $this->faker->uuid(),
            'lot_number' => $this->faker->optional()->bothify('LOT-####??'),
            'expiry_date' => $this->faker->optional()->dateTimeBetween('+1 month', '+2 years'),
            'notes' => $this->faker->optional()->sentence,
            'created_by' => $user->id
        ];
    }

    public function in()
    {
        return $this->state([
            'movement_type' => 'in'
        ]);
    }

    public function out()
    {
        return $this->state([
            'movement_type' => 'out'
        ]);
    }

    public function transfer()
    {
        return $this->state([
            'movement_type' => 'transfer'
        ]);
    }

    public function adjustment()
    {
        return $this->state([
            'movement_type' => 'adjustment'
        ]);
    }
}
