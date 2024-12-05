<?php

namespace Database\Factories;

use App\Models\MarketplaceOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketplaceOrderFactory extends Factory
{
    protected $model = MarketplaceOrder::class;

    public function definition(): array
    {
        $totalAmount = fake()->randomFloat(4, 100, 10000);
        $shippingAmount = fake()->randomFloat(4, 0, 100);
        $taxAmount = $totalAmount * 0.1;
        $discountAmount = fake()->randomFloat(4, 0, $totalAmount * 0.2);
        $grandTotal = $totalAmount + $shippingAmount + $taxAmount - $discountAmount;

        return [
            'order_number' => 'MPO-' . fake()->unique()->numerify('######'),
            'marketplace' => fake()->randomElement(['Tokopedia', 'Shopee', 'Lazada', 'Bukalapak']),
            'external_order_id' => fake()->uuid(),
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->phoneNumber(),
            'customer_email' => fake()->optional()->safeEmail(),
            'shipping_address' => fake()->address(),
            'total_amount' => $totalAmount,
            'shipping_amount' => $shippingAmount,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'grand_total' => $grandTotal,
            'status' => fake()->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'payment_status' => fake()->randomElement(['unpaid', 'paid', 'partially_paid', 'refunded']),
        ];
    }

    public function pending(): static
    {
        return $this->state([
            'status' => 'pending',
        ]);
    }

    public function processing(): static
    {
        return $this->state([
            'status' => 'processing',
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
            'payment_status' => 'paid',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
            'payment_status' => 'refunded',
        ]);
    }

    public function withTokopedia(): static
    {
        return $this->state([
            'marketplace' => 'Tokopedia',
        ]);
    }

    public function withShopee(): static
    {
        return $this->state([
            'marketplace' => 'Shopee',
        ]);
    }
}
