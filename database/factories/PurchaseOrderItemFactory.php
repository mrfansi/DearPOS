<?php

namespace Database\Factories;

use App\Models\PurchaseOrderItem;
use App\Models\PurchaseOrder;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\UnitOfMeasure;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderItemFactory extends Factory
{
    protected $model = PurchaseOrderItem::class;

    public function definition()
    {
        $quantity = $this->faker->randomFloat(4, 1, 100);
        $unitPrice = $this->faker->randomFloat(4, 10, 500);
        $totalAmount = $quantity * $unitPrice;
        $taxAmount = $totalAmount * 0.1;
        $discountAmount = $totalAmount * 0.05;

        return [
            'purchase_order_id' => PurchaseOrder::factory(),
            'product_id' => Product::factory(),
            'variant_id' => $this->faker->optional()->passthrough(ProductVariant::factory()),
            'quantity' => $quantity,
            'received_quantity' => $this->faker->randomFloat(4, 0, $quantity),
            'unit_id' => function () {
                $unit = UnitOfMeasure::first();
                if (!$unit) {
                    $unit = UnitOfMeasure::factory()->create();
                }
                return $unit->id;
            },
            'unit_price' => $unitPrice,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'notes' => $this->faker->optional()->text(200),
        ];
    }

    public function withFullyReceived()
    {
        return $this->state(function (array $attributes) {
            return [
                'received_quantity' => $attributes['quantity'],
            ];
        });
    }

    public function withPartiallyReceived()
    {
        return $this->state(function (array $attributes) {
            return [
                'received_quantity' => $this->faker->randomFloat(4, 0, $attributes['quantity']),
            ];
        });
    }
}
