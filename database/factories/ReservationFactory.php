<?php

namespace Database\Factories;

use App\Models\Reservation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ReservationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Reservation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'reservation_number' => $this->faker->unique()->numerify('RES#####'),
            'customer_id' => $this->faker->optional()->uuid,
            'pos_counter_id' => $this->faker->optional()->uuid,
            'reservation_date' => $this->faker->date(),
            'reservation_time' => $this->faker->dateTime(),
            'expected_duration' => $this->faker->numberBetween(30, 180),
            'status' => $this->faker->randomElement(['confirmed', 'in_progress', 'completed', 'cancelled']),
            'total_guests' => $this->faker->numberBetween(1, 20),
            'special_requests' => $this->faker->sentence,
            'deposit_amount' => $this->faker->randomFloat(4, 0, 500),
            'notes' => $this->faker->sentence,
            'created_by' => $this->faker->uuid,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
