<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\PosCounter;
use App\Models\Reservation;
use App\Models\SalesTransaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $statuses = ['confirmed', 'in_progress', 'completed', 'cancelled'];
        $totalGuests = fake()->numberBetween(1, 10);
        $depositAmount = fake()->optional()->randomFloat(4, 50, 500);

        return [
            'reservation_number' => 'RES-' . fake()->unique()->numerify('######'),
            'customer_id' => fake()->optional()->passThrough(fn() => Customer::factory()),
            'pos_counter_id' => PosCounter::factory(),
            'sales_transaction_id' => fake()->optional()->passThrough(fn() => SalesTransaction::factory()),
            'reservation_date' => fake()->dateTimeBetween('now', '+1 month'),
            'reservation_time' => fake()->dateTimeBetween('now', '+1 month'),
            'expected_duration' => fake()->optional()->numberBetween(30, 240),
            'status' => fake()->randomElement($statuses),
            'total_guests' => $totalGuests,
            'special_requests' => fake()->optional()->sentence(),
            'deposit_amount' => $depositAmount,
            'notes' => fake()->optional()->sentence(),
            'created_by' => User::factory(),
        ];
    }

    public function confirmed(): static
    {
        return $this->state([
            'status' => 'confirmed',
        ]);
    }

    public function inProgress(): static
    {
        return $this->state([
            'status' => 'in_progress',
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'status' => 'completed',
        ]);
    }

    public function cancelled(): static
    {
        return $this->state([
            'status' => 'cancelled',
        ]);
    }

    public function withCustomer(): static
    {
        return $this->state([
            'customer_id' => Customer::factory(),
        ]);
    }

    public function withSalesTransaction(): static
    {
        return $this->state([
            'sales_transaction_id' => SalesTransaction::factory(),
        ]);
    }
}
