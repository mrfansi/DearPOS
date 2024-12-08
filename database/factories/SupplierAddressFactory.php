<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierAddressFactory extends Factory
{
    protected $model = SupplierAddress::class;

    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'address_type' => $this->faker->randomElement(['billing', 'shipping', 'both']),
            'address_line_1' => $this->faker->streetAddress(),
            'address_line_2' => $this->faker->optional()->secondaryAddress(),
            'city' => $this->faker->city(),
            'state' => $this->faker->state(),
            'postal_code' => $this->faker->postcode(),
            'country' => $this->faker->country(),
            'is_default' => $this->faker->boolean(20),
        ];
    }

    public function defaultAddress()
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
        ]);
    }

    public function billingAddress()
    {
        return $this->state(fn (array $attributes) => [
            'address_type' => 'billing',
        ]);
    }

    public function shippingAddress()
    {
        return $this->state(fn (array $attributes) => [
            'address_type' => 'shipping',
        ]);
    }
}
