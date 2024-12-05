<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\SupplierReturn;
use App\Models\SupplierReturnItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SupplierReturnItemFactory extends Factory
{
    protected $model = SupplierReturnItem::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(),
            'reason' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'supplier_return_id' => SupplierReturn::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
