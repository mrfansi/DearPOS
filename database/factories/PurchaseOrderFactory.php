<?php

namespace Database\Factories;

use App\Models\PurchaseOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PurchaseOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PurchaseOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'po_number' => $this->faker->unique()->numerify('PO#####'),
            'supplier_id' => $this->faker->optional()->uuid,
            'order_date' => $this->faker->date(),
            'expected_delivery_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),
            'notes' => $this->faker->sentence,
            'subtotal' => $this->faker->randomFloat(4, 0, 10000),
            'tax_amount' => $this->faker->randomFloat(4, 0, 1000),
            'total_amount' => $this->faker->randomFloat(4, 0, 11000),
            'currency_id' => $this->faker->optional()->uuid,
            'created_by' => $this->faker->uuid,
            'approved_by' => $this->faker->optional()->uuid,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
