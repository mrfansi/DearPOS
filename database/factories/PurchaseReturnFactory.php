<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use App\Models\PurchaseReturn;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseReturnFactory extends Factory
{
    protected $model = PurchaseReturn::class;

    public function definition()
    {
        $purchaseOrder = PurchaseOrder::factory()->create();
        $totalAmount = $this->faker->randomFloat(4, 50, 5000);

        return [
            'return_number' => 'PR-'.$this->faker->unique()->numberBetween(1000, 9999),
            'purchase_order_id' => $purchaseOrder,
            'supplier_id' => $purchaseOrder->supplier_id,
            'return_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['draft', 'pending', 'approved', 'completed', 'cancelled']),
            'reason' => $this->faker->randomElement(['defective', 'wrong_item', 'excess_quantity', 'damaged', 'other']),
            'total_amount' => $totalAmount,
            'notes' => $this->faker->optional()->text(200),
            'created_by' => User::factory(),
            'approved_by' => $this->faker->optional()->passthrough(User::factory()),
            'approved_at' => $this->faker->optional()->dateTime(),
        ];
    }

    public function draft()
    {
        return $this->state([
            'status' => 'draft',
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
        ]);
    }

    public function approved()
    {
        return $this->state([
            'status' => 'approved',
            'approved_by' => User::factory(),
            'approved_at' => $this->faker->dateTime(),
        ]);
    }

    public function completed()
    {
        return $this->state([
            'status' => 'completed',
            'approved_by' => User::factory(),
            'approved_at' => $this->faker->dateTime(),
        ]);
    }

    public function cancelled()
    {
        return $this->state([
            'status' => 'cancelled',
        ]);
    }
}
