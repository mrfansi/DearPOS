<?php

namespace Database\Factories;

use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoicePaymentFactory extends Factory
{
    protected $model = InvoicePayment::class;

    public function definition(): array
    {
        return [
            'invoice_id' => Invoice::factory(),
            'payment_method' => fake()->randomElement(['cash', 'card', 'bank_transfer', 'e_wallet', 'qris']),
            'payment_reference' => fake()->optional()->bothify('PAY-####-????'),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'payment_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'notes' => fake()->optional()->sentence(),
            'payment_gateway_id' => fake()->boolean(30) ? PaymentGateway::factory() : null,
            'transaction_id' => fake()->optional()->uuid(),
        ];
    }

    public function cash(): static
    {
        return $this->state([
            'payment_method' => 'cash',
            'payment_gateway_id' => null,
        ]);
    }

    public function card(): static
    {
        return $this->state([
            'payment_method' => 'card',
            'payment_reference' => fake()->creditCardNumber(),
            'payment_gateway_id' => PaymentGateway::factory(),
        ]);
    }

    public function eWallet(): static
    {
        return $this->state([
            'payment_method' => 'e_wallet',
            'payment_gateway_id' => PaymentGateway::factory(),
        ]);
    }

    public function qris(): static
    {
        return $this->state([
            'payment_method' => 'qris',
            'payment_gateway_id' => PaymentGateway::factory(),
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }

    public function failed(): static
    {
        return $this->state([
            'status' => 'failed',
        ]);
    }

    public function refunded(): static
    {
        return $this->state([
            'status' => 'refunded',
        ]);
    }
}
