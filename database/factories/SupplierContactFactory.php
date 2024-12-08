<?php

namespace Database\Factories;

use App\Models\Supplier;
use App\Models\SupplierContact;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierContactFactory extends Factory
{
    protected $model = SupplierContact::class;

    public function definition(): array
    {
        return [
            'supplier_id' => Supplier::factory(),
            'name' => $this->faker->name(),
            'position' => $this->faker->optional()->jobTitle(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => $this->faker->optional()->phoneNumber(),
            'mobile' => $this->faker->optional()->phoneNumber(),
            'is_primary' => $this->faker->boolean(20),
            'notes' => $this->faker->optional()->paragraph(),
        ];
    }

    public function primaryContact()
    {
        return $this->state(fn (array $attributes) => [
            'is_primary' => true,
        ]);
    }
}
