<?php

namespace Database\Factories;

use App\Models\PreOrder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PreOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PreOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'pre_order_number' => $this->faker->unique()->numerify('PRE#####'),
            'customer_id' => $this->faker->optional()->uuid,
            'pos_counter_id' => $this->faker->optional()->uuid,
            'sales_transaction_id' => $this->faker->optional()->uuid,
            'order_date' => $this->faker->date(),
            'expected_delivery_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'processing', 'completed', 'cancelled']),
            'total_amount' => $this->faker->randomFloat(4, 0, 10000),
            'deposit_amount' => $this->faker->randomFloat(4, 0, 2000),
            'payment_status' => $this->faker->randomElement(['unpaid', 'partial', 'paid']),
            'notes' => $this->faker->sentence,
            'created_by' => $this->faker->uuid,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
