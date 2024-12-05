<?php

namespace Database\Factories;

use App\Models\PaymentGateway;
use Illuminate\Database\Eloquent\Factories\Factory;

class PaymentGatewayFactory extends Factory
{
    protected $model = PaymentGateway::class;

    public function definition(): array
    {
        $paymentGateways = [
            'stripe' => [
                'api_key' => 'sk_test_' . fake()->uuid(),
                'publishable_key' => 'pk_test_' . fake()->uuid(),
            ],
            'midtrans' => [
                'server_key' => 'SB-Mid-server-' . fake()->uuid(),
                'client_key' => 'SB-Mid-client-' . fake()->uuid(),
            ],
            'xendit' => [
                'secret_key' => 'xnd_' . fake()->uuid(),
            ],
        ];

        $gatewayName = fake()->randomElement(array_keys($paymentGateways));

        return [
            'name' => ucfirst($gatewayName),
            'code' => strtoupper($gatewayName),
            'credentials' => $paymentGateways[$gatewayName],
            'is_active' => fake()->boolean(80),
        ];
    }

    public function stripe(): static
    {
        return $this->state([
            'name' => 'Stripe',
            'code' => 'STRIPE',
            'credentials' => [
                'api_key' => 'sk_test_' . fake()->uuid(),
                'publishable_key' => 'pk_test_' . fake()->uuid(),
            ],
        ]);
    }

    public function midtrans(): static
    {
        return $this->state([
            'name' => 'Midtrans',
            'code' => 'MIDTRANS',
            'credentials' => [
                'server_key' => 'SB-Mid-server-' . fake()->uuid(),
                'client_key' => 'SB-Mid-client-' . fake()->uuid(),
            ],
        ]);
    }

    public function xendit(): static
    {
        return $this->state([
            'name' => 'Xendit',
            'code' => 'XENDIT',
            'credentials' => [
                'secret_key' => 'xnd_' . fake()->uuid(),
            ],
        ]);
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
}
