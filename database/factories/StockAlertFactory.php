<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\StockAlert;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StockAlertFactory extends Factory
{
    protected $model = StockAlert::class;

    public function definition(): array
    {
        return [
            'alert_type' => $this->faker->word(),
            'message' => $this->faker->word(),
            'is_resolved' => $this->faker->boolean(),
            'resolved_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Product::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
