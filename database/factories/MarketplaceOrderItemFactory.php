<?php

namespace Database\Factories;

use App\Models\MarketplaceOrder;
use App\Models\MarketplaceOrderItem;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class MarketplaceOrderItemFactory extends Factory
{
    protected $model = MarketplaceOrderItem::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(4, 1, 10);
        $unitPrice = fake()->randomFloat(4, 10, 1000);
        $discountAmount = fake()->randomFloat(4, 0, $unitPrice * 0.3);
        $taxAmount = ($unitPrice - $discountAmount) * 0.1;
        $totalPrice = ($quantity * $unitPrice) - $discountAmount + $taxAmount;

        return [
            'marketplace_order_id' => MarketplaceOrder::factory(),
            'product_id' => Product::factory(),
            'product_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'external_item_id' => fake()->optional()->uuid(),
            'name' => fake()->words(3, true),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_price' => $totalPrice,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
        ];
    }

    public function withVariant(): static
    {
        return $this->state([
            'product_variant_id' => ProductVariant::factory(),
        ]);
    }

    public function withoutDiscount(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = $attributes['quantity'];
            $unitPrice = $attributes['unit_price'];
            $taxAmount = $unitPrice * 0.1;
            $totalPrice = $quantity * $unitPrice + $taxAmount;

            return [
                'discount_amount' => 0,
                'total_price' => $totalPrice,
                'tax_amount' => $taxAmount,
            ];
        });
    }

    public function withoutTax(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = $attributes['quantity'];
            $unitPrice = $attributes['unit_price'];
            $discountAmount = $attributes['discount_amount'];
            $totalPrice = ($quantity * $unitPrice) - $discountAmount;

            return [
                'tax_amount' => 0,
                'total_price' => $totalPrice,
            ];
        });
    }
}
