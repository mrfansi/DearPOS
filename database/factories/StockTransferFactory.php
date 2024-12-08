<?php

namespace Database\Factories;

use App\Models\StockTransfer;
use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockTransferFactory extends Factory
{
    protected $model = StockTransfer::class;

    public function definition(): array
    {
        $sourceWarehouse = Warehouse::factory()->create();
        $destinationWarehouse = Warehouse::factory()->create();
        $creator = User::factory()->create();
        $status = $this->faker->randomElement(['draft', 'pending', 'in_transit', 'completed', 'cancelled']);

        return [
            'transfer_number' => 'TRF-' . strtoupper(substr(uniqid(), -8)),
            'source_warehouse_id' => $sourceWarehouse->id,
            'destination_warehouse_id' => $destinationWarehouse->id,
            'status' => $status,
            'transfer_date' => $this->faker->dateTimeBetween('-1 month', '+1 month'),
            'notes' => $this->faker->optional()->sentence,
            'created_by' => $creator->id,
            'approved_by' => in_array($status, ['in_transit', 'completed']) ? User::factory()->create()->id : null,
            'approved_at' => in_array($status, ['in_transit', 'completed']) ? now() : null,
            'completed_by' => $status === 'completed' ? User::factory()->create()->id : null,
            'completed_at' => $status === 'completed' ? now() : null
        ];
    }

    public function draft()
    {
        return $this->state([
            'status' => 'draft',
            'approved_by' => null,
            'approved_at' => null,
            'completed_by' => null,
            'completed_at' => null
        ]);
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
            'approved_by' => null,
            'approved_at' => null,
            'completed_by' => null,
            'completed_at' => null
        ]);
    }

    public function inTransit()
    {
        return $this->state(function (array $attributes) {
            $approver = User::factory()->create();
            return [
                'status' => 'in_transit',
                'approved_by' => $approver->id,
                'approved_at' => now(),
                'completed_by' => null,
                'completed_at' => null
            ];
        });
    }

    public function completed()
    {
        return $this->state(function (array $attributes) {
            $approver = User::factory()->create();
            $completer = User::factory()->create();
            return [
                'status' => 'completed',
                'approved_by' => $approver->id,
                'approved_at' => now()->subHours(2),
                'completed_by' => $completer->id,
                'completed_at' => now()
            ];
        });
    }

    public function cancelled()
    {
        return $this->state([
            'status' => 'cancelled',
            'approved_by' => null,
            'approved_at' => null,
            'completed_by' => null,
            'completed_at' => null
        ]);
    }
}
