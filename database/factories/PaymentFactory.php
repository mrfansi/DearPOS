<?php

namespace Database\Factories;

use App\Models\Currency;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    public function definition(): array
    {
        return [
            'sales_transaction_id' => SalesTransaction::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'amount' => $this->faker->randomFloat(4, 10, 1000),
            'currency_id' => Currency::factory(),
            'exchange_rate' => $this->faker->randomFloat(4, 0.5, 2),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'payment_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'reference_number' => $this->faker->optional()->uuid(),
            'notes' => $this->faker->optional()->sentence(),
            'is_partial' => $this->faker->boolean(20)
        ];
    }

    public function completed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed'
        ]);
    }

    public function partial()
    {
        return $this->state(fn (array $attributes) => [
            'is_partial' => true
        ]);
    }
};
