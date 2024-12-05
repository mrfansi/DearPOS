<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    protected $model = Customer::class;

    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'is_active' => fake()->boolean(80),
        ];
    }

    public function active(): static
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function withTaxExemption(): static
    {
        return $this->afterCreating(function (Customer $customer) {
            $customer->taxExemptions()->save(
                TaxExemptionFactory::new()->make()
            );
        });
    }

    public function withActiveDeposit(): static
    {
        return $this->afterCreating(function (Customer $customer) {
            $customer->customerDeposits()->save(
                CustomerDepositFactory::new()->active()->make()
            );
        });
    }
}
