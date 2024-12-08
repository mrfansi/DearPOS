<?php

namespace Database\Factories;

use App\Models\GoodsReceipt;
use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class GoodsReceiptFactory extends Factory
{
    protected $model = GoodsReceipt::class;

    public function definition()
    {
        return [
            'purchase_order_id' => PurchaseOrder::factory(),
            'receipt_number' => 'GR-'.$this->faker->unique()->numberBetween(1000, 9999),
            'receipt_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['draft', 'confirmed', 'cancelled']),
            'notes' => $this->faker->optional()->text(200),
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
