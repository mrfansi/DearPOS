<?php

namespace Database\Factories;

use App\Models\ProductBarcode;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductBarcodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductBarcode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'product_id' => $this->faker->optional()->uuid,
            'variant_id' => $this->faker->optional()->uuid,
            'barcode_type' => $this->faker->randomElement(['EAN13', 'UPC', 'CODE128']),
            'barcode_value' => $this->faker->unique()->ean13,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
