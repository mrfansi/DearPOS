<?php

namespace Database\Factories;

use App\Models\QrisTransaction;
use App\Models\SalesTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class QrisTransactionFactory extends Factory
{
    protected $model = QrisTransaction::class;

    public function definition(): array
    {
        $statuses = ['pending', 'success', 'failed', 'expired'];
        $amount = fake()->randomFloat(4, 10, 10000);

        return [
            'transaction_id' => SalesTransaction::factory(),
            'qris_id' => 'QRIS-' . fake()->unique()->uuid(),
            'amount' => $amount,
            'status' => fake()->randomElement($statuses),
            'expires_at' => fake()->optional()->dateTimeBetween('now', '+1 hour'),
        ];
    }

    public function pending(): static
    {
        return $this->state([
            'status' => 'pending',
        ]);
    }

    public function success(): static
    {
        return $this->state([
            'status' => 'success',
        ]);
    }

    public function failed(): static
    {
        return $this->state([
            'status' => 'failed',
        ]);
    }

    public function expired(): static
    {
        return $this->state([
            'status' => 'expired',
            'expires_at' => now()->subMinutes(30),
        ]);
    }

    public function withSmallAmount(): static
    {
        return $this->state([
            'amount' => fake()->randomFloat(4, 1, 50),
        ]);
    }

    public function withLargeAmount(): static
    {
        return $this->state([
            'amount' => fake()->randomFloat(4, 10000, 100000),
        ]);
    }
}
