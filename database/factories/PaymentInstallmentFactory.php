<?php

namespace Database\Factories;

use App\Models\Payment;
use App\Models\PaymentInstallment;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentInstallmentFactory extends Factory
{
    protected $model = PaymentInstallment::class;

    public function definition(): array
    {
        $dueDate = $this->faker->dateTimeBetween('now', '+6 months');
        $paidDate = $this->faker->optional(0.5)->dateTimeBetween('now', $dueDate);

        return [
            'payment_id' => Payment::factory(),
            'currency_id' => function (array $attributes) {
                $payment = Payment::find($attributes['payment_id'])
                    ?? Payment::factory()->create();

                return $payment->currency_id;
            },
            'installment_number' => $this->faker->numberBetween(1, 12),
            'amount' => $this->faker->randomFloat(4, 50, 500),
            'due_date' => $dueDate,
            'paid_date' => $paidDate,
            'status' => $paidDate ? 'paid' : 'pending',
            'notes' => $this->faker->optional()->sentence(),
        ];
    }

    public function pending()
    {
        return $this->state(fn (array $attributes) => [
            'paid_date' => null,
            'status' => 'pending',
        ]);
    }

    public function paid()
    {
        return $this->state(fn (array $attributes) => [
            'paid_date' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'status' => 'paid',
        ]);
    }
}
