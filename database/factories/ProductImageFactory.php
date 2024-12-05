<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition(): array
    {
        return [
            'file_name' => $this->faker->name(),
            'file_path' => $this->faker->word(),
            'mime_type' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'is_primary' => $this->faker->boolean(),
            'display_order' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'product_id' => Product::factory(),
        ];
    }
}
