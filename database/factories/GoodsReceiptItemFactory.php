<?php

namespace Database\Factories;

use App\Models\GoodsReceiptItem;
use App\Models\GoodsReceipt;
use App\Models\PurchaseOrderItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoodsReceiptItemFactory extends Factory
{
    protected $model = GoodsReceiptItem::class;

    public function definition()
    {
        $purchaseOrderItem = PurchaseOrderItem::factory()->create();
        $quantity = $this->faker->randomFloat(4, 1, $purchaseOrderItem->quantity);
        $unitCost = $this->faker->randomFloat(4, 10, 500);
        $totalAmount = $quantity * $unitCost;

        return [
            'goods_receipt_id' => GoodsReceipt::factory(),
            'purchase_order_item_id' => $purchaseOrderItem,
            'product_id' => $purchaseOrderItem->product_id,
            'quantity' => $quantity,
            'unit_cost' => $unitCost,
            'total_amount' => $totalAmount,
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
