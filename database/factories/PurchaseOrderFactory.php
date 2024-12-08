<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Currency;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseOrderFactory extends Factory
{
    protected $model = PurchaseOrder::class;

    public function definition()
    {
        $totalAmount = $this->faker->randomFloat(4, 100, 10000);
        $taxAmount = $totalAmount * 0.1;
        $discountAmount = $totalAmount * 0.05;
        $shippingAmount = $this->faker->randomFloat(4, 10, 100);

        return [
            'order_number' => 'PO-' . $this->faker->unique()->numberBetween(1000, 9999),
            'supplier_id' => Supplier::factory(),
            'warehouse_id' => Warehouse::factory(),
            'currency_id' => Currency::factory(),
            'status' => $this->faker->randomElement(['draft', 'pending', 'approved', 'received', 'cancelled']),
            'order_date' => $this->faker->date(),
            'expected_date' => $this->faker->optional()->date(),
            'total_amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'discount_amount' => $discountAmount,
            'shipping_amount' => $shippingAmount,
            'grand_total' => $totalAmount + $taxAmount - $discountAmount + $shippingAmount,
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

    public function received()
    {
        return $this->state([
            'status' => 'received',
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
