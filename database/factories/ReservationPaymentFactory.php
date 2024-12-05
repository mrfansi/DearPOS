<?php

namespace Database\Factories;

use App\Models\Reservation;
use App\Models\ReservationPayment;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationPaymentFactory extends Factory
{
    protected $model = ReservationPayment::class;

    public function definition(): array
    {
        return [
            'reservation_id' => Reservation::factory(),
            'payment_method' => fake()->randomElement(['cash', 'card', 'bank_transfer', 'e_wallet', 'qris']),
            'payment_reference' => fake()->optional()->bothify('PAY-####-????'),
            'amount' => fake()->randomFloat(2, 10, 1000),
            'payment_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['pending', 'completed', 'failed', 'refunded']),
            'notes' => fake()->optional()->sentence(),
        ];
    }

    public function cash(): static
    {
        return $this->state([
            'payment_method' => 'cash',
        ]);
    }

    public function card(): static
    {
        return $this->state([
            'payment_method' => 'card',
            'payment_reference' => fake()->creditCardNumber(),
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }

    public function failed(): static
    {
        return $this->state([
            'status' => 'failed',
        ]);
    }
}
