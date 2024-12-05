<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use App\Models\PurchaseReceipt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PurchaseReceiptFactory extends Factory
{
    protected $model = PurchaseReceipt::class;

    public function definition(): array
    {
        return [
            'receipt_date' => Carbon::now(),
            'status' => $this->faker->word(),
            'notes' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'purchase_order_id' => PurchaseOrder::factory(),
        ];
    }
}
