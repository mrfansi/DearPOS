<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Supplier;
use App\Models\SupplierProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierProductFactory extends Factory
{
    protected $model = SupplierProduct::class;

    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'product_id' => Product::factory(),
            'supplier_product_code' => $this->faker->optional()->regexify('[A-Z]{2}[0-9]{4}'),
            'supplier_product_name' => $this->faker->optional()->words(3, true),
            'unit_cost' => $this->faker->randomFloat(4, 1, 1000),
            'minimum_order_quantity' => $this->faker->randomFloat(4, 1, 100),
            'lead_time_days' => $this->faker->numberBetween(1, 30),
            'is_preferred' => $this->faker->boolean(20),
            'notes' => $this->faker->optional()->paragraph()
        ];
    }

    public function preferred()
    {
        return $this->state(fn (array $attributes) => [
            'is_preferred' => true
        ]);
    }
};
