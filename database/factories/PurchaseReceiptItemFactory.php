<?php

namespace Database\Factories;

use App\Models\PurchaseReceiptItem;
use App\Models\PurchaseReceipt;
use App\Models\PurchaseOrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseReceiptItemFactory extends Factory
{
    protected $model = PurchaseReceiptItem::class;

    public function definition()
    {
        $purchaseOrderItem = PurchaseOrderItem::factory()->create();

        return [
            'receipt_id' => PurchaseReceipt::factory(),
            'purchase_order_item_id' => $purchaseOrderItem,
            'quantity_received' => $this->faker->randomFloat(4, 0, $purchaseOrderItem->quantity),
            'lot_number' => $this->faker->optional()->bothify('LOT-#####'),
            'expiry_date' => $this->faker->optional(0.5)->dateTimeBetween('+1 year', '+3 years')?->format('Y-m-d'),
            'notes' => $this->faker->optional()->text(200),
        ];
    }

    public function withFullQuantity()
    {
        return $this->state(function (array $attributes) {
            $purchaseOrderItem = PurchaseOrderItem::find($attributes['purchase_order_item_id']);
            return [
                'quantity_received' => $purchaseOrderItem->quantity,
            ];
        });
    }
}
