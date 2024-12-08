<?php

namespace Database\Factories;

use App\Models\PurchaseReturnItem;
use App\Models\PurchaseReturn;
use App\Models\PurchaseOrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseReturnItemFactory extends Factory
{
    protected $model = PurchaseReturnItem::class;

    public function definition()
    {
        $purchaseOrderItem = PurchaseOrderItem::factory()->create();
        $quantity = $this->faker->randomFloat(4, 1, $purchaseOrderItem->quantity);
        $unitPrice = $purchaseOrderItem->unit_price;
        $totalAmount = $quantity * $unitPrice;

        return [
            'return_id' => PurchaseReturn::factory(),
            'purchase_order_item_id' => $purchaseOrderItem,
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'total_amount' => $totalAmount,
            'reason' => $this->faker->randomElement(['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']),
            'notes' => $this->faker->optional()->text(200),
        ];
    }

    public function withFullQuantity()
    {
        return $this->state(function (array $attributes) {
            $purchaseOrderItem = PurchaseOrderItem::find($attributes['purchase_order_item_id']);
            return [
                'quantity' => $purchaseOrderItem->quantity,
            ];
        });
    }
}
