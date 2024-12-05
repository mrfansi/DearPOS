<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductBarcode;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductBarcodeFactory extends Factory
{
    protected $model = ProductBarcode::class;

    public function definition(): array
    {
        $barcodeTypes = ['EAN13', 'CODE128', 'UPC'];
        
        return [
            'product_id' => Product::factory(),
            'product_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'barcode_type' => fake()->randomElement($barcodeTypes),
            'barcode' => fake()->ean13(),
            'is_primary' => fake()->boolean(20),
        ];
    }

    public function primary(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }

    public function ean13(): static
    {
        return $this->state(fn (array $attributes) => [
            'barcode_type' => 'EAN13',
            'barcode' => fake()->ean13(),
        ]);
    }

    public function code128(): static
    {
        return $this->state(fn (array $attributes) => [
            'barcode_type' => 'CODE128',
            'barcode' => strtoupper(fake()->bothify('??####????##')),
        ]);
    }
}
