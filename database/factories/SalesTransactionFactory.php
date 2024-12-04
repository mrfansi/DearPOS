<?php

namespace Database\Factories;

use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SalesTransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SalesTransaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'transaction_number' => $this->faker->unique()->numerify('TRX#####'),
            'customer_id' => $this->faker->optional()->uuid,
            'pos_counter_id' => $this->faker->optional()->uuid,
            'user_id' => $this->faker->uuid,
            'transaction_date' => $this->faker->dateTime(),
            'status' => $this->faker->randomElement(['pending', 'completed', 'cancelled']),
            'total_amount' => $this->faker->randomFloat(4, 0, 10000),
            'subtotal' => $this->faker->randomFloat(4, 0, 8000),
            'tax_amount' => $this->faker->randomFloat(4, 0, 2000),
            'discount_amount' => $this->faker->randomFloat(4, 0, 1000),
            'payment_status' => $this->faker->randomElement(['unpaid', 'partial', 'paid']),
            'notes' => $this->faker->sentence,
            'currency_id' => $this->faker->optional()->uuid,
            'is_void' => $this->faker->boolean,
            'void_reason' => $this->faker->optional()->sentence,
            'is_reservation' => $this->faker->boolean,
            'reservation_date' => $this->faker->optional()->dateTime(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
