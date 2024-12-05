<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationItemFactory extends Factory
{
    protected $model = ReservationItem::class;

    public function definition(): array
    {
        $quantity = fake()->randomFloat(2, 1, 10);
        $unitPrice = fake()->randomFloat(2, 10, 1000);
        $discountAmount = fake()->randomFloat(2, 0, $unitPrice * 0.3);
        $taxAmount = ($unitPrice - $discountAmount) * 0.1; // 10% tax
        $totalAmount = ($quantity * $unitPrice) - $discountAmount + $taxAmount;

        return [
            'reservation_id' => Reservation::factory(),
            'product_id' => Product::factory(),
            'product_variant_id' => fake()->boolean(30) ? ProductVariant::factory() : null,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'discount_amount' => $discountAmount,
            'tax_amount' => $taxAmount,
            'total_amount' => $totalAmount,
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function withoutDiscount(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = $attributes['quantity'];
            $unitPrice = $attributes['unit_price'];
            $taxAmount = $unitPrice * 0.1;
            $totalAmount = ($quantity * $unitPrice) + $taxAmount;

            return [
                'discount_amount' => 0,
                'tax_amount' => $taxAmount,
                'total_amount' => $totalAmount,
            ];
        });
    }

    public function withoutTax(): static
    {
        return $this->state(function (array $attributes) {
            $quantity = $attributes['quantity'];
            $unitPrice = $attributes['unit_price'];
            $discountAmount = $attributes['discount_amount'];
            $totalAmount = ($quantity * $unitPrice) - $discountAmount;

            return [
                'tax_amount' => 0,
                'total_amount' => $totalAmount,
            ];
        });
    }
}
