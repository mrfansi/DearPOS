<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\UnitOfMeasure;
use App\Models\User;
use App\Models\WasteRecord;
use Illuminate\Database\Eloquent\Factories\Factory;

class WasteRecordFactory extends Factory
{
    protected $model = WasteRecord::class;

    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'quantity' => fake()->randomFloat(4, 0.1, 100),
            'unit_id' => UnitOfMeasure::factory(),
            'reason' => fake()->randomElement([
                'expired', 
                'damaged', 
                'quality_issue', 
                'overstock', 
                'production_error'
            ]),
            'notes' => fake()->optional()->sentence(),
            'recorded_by' => User::factory(),
            'recorded_at' => fake()->dateTimeBetween('-1 month', 'now'),
        ];
    }

    public function expired(): static
    {
        return $this->state([
            'reason' => 'expired',
        ]);
    }

    public function damaged(): static
    {
        return $this->state([
            'reason' => 'damaged',
        ]);
    }

    public function qualityIssue(): static
    {
        return $this->state([
            'reason' => 'quality_issue',
        ]);
    }

    public function overstock(): static
    {
        return $this->state([
            'reason' => 'overstock',
        ]);
    }

    public function largeQuantity(): static
    {
        return $this->state([
            'quantity' => fake()->randomFloat(4, 50, 500),
        ]);
    }

    public function smallQuantity(): static
    {
        return $this->state([
            'quantity' => fake()->randomFloat(4, 0.1, 5),
        ]);
    }
}
