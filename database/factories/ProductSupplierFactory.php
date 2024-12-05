<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductSupplier;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductSupplierFactory extends Factory
{
    protected $model = ProductSupplier::class;

    public function definition(): array
    {
        return [
            'supplier_sku' => $this->faker->word(),
            'purchase_price' => $this->faker->randomFloat(),
            'minimum_order_quantity' => $this->faker->randomNumber(),
            'lead_time_days' => $this->faker->randomNumber(),
            'is_preferred' => $this->faker->boolean(),
            'last_purchase_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Product::factory(),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
