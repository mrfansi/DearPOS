<?php

namespace Database\Factories;

use App\Models\PurchaseReceipt;
use App\Models\PurchaseOrder;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseReceiptFactory extends Factory
{
    protected $model = PurchaseReceipt::class;

    public function definition()
    {
        return [
            'receipt_number' => 'PR-' . $this->faker->unique()->numberBetween(1000, 9999),
            'purchase_order_id' => PurchaseOrder::factory(),
            'receipt_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['draft', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional()->text(200),
            'received_by' => User::factory(),
        ];
    }

    public function draft()
    {
        return $this->state([
            'status' => 'draft',
        ]);
    }

    public function confirmed()
    {
        return $this->state([
            'status' => 'confirmed',
        ]);
    }

    public function cancelled()
    {
        return $this->state([
            'status' => 'cancelled',
        ]);
    }
}
