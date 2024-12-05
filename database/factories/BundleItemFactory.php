<?php

namespace Database\Factories;

use App\Models\BundleItem;
use App\Models\Product;
use App\Models\ProductBundle;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BundleItemFactory extends Factory
{
    protected $model = BundleItem::class;

    public function definition(): array
    {
        return [
            'quantity' => $this->faker->randomNumber(),
            'price_adjustment' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'bundle_id' => ProductBundle::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
