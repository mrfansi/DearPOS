<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerDeposit;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerDepositFactory extends Factory
{
    protected $model = CustomerDeposit::class;

    public function definition(): array
    {
        $amount = fake()->randomFloat(4, 100, 5000);
        $usedAmount = fake()->randomFloat(4, 0, $amount);

        return [
            'customer_id' => Customer::factory(),
            'amount' => $amount,
            'used_amount' => $usedAmount,
            'remaining_amount' => $amount - $usedAmount,
            'deposit_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'expiry_date' => fake()->optional()->dateTimeBetween('now', '+1 year'),
            'notes' => fake()->optional()->sentence(),
            'status' => fake()->randomElement(['active', 'used', 'expired']),
        ];
    }

    public function active(): static
    {
        return $this->state([
            'status' => 'active',
            'used_amount' => 0,
            'remaining_amount' => function (array $attributes) {
                return $attributes['amount'];
            },
        ]);
    }

    public function used(): static
    {
        return $this->state([
            'status' => 'used',
            'used_amount' => function (array $attributes) {
                return $attributes['amount'];
            },
            'remaining_amount' => 0,
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'status' => 'expired',
            'expiry_date' => fake()->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    public function withPartialUsage(): static
    {
        return $this->state(function (array $attributes) {
            $usedAmount = fake()->randomFloat(4, 0, $attributes['amount']);
            return [
                'used_amount' => $usedAmount,
                'remaining_amount' => $attributes['amount'] - $usedAmount,
                'status' => $usedAmount >= $attributes['amount'] ? 'used' : 'active',
            ];
        });
    }
}
