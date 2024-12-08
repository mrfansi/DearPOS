<?php

namespace Database\Factories;

use App\Models\StorageLocation;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class StorageLocationFactory extends Factory
{
    protected $model = StorageLocation::class;

    public function definition(): array
    {
        $warehouse = Warehouse::factory()->create();

        return [
            'warehouse_id' => $warehouse->id,
            'name' => $this->faker->words(2, true) . ' Location',
            'code' => 'LOC-' . strtoupper(substr(uniqid(), -8)),
            'description' => $this->faker->optional()->sentence,
            'is_active' => $this->faker->boolean(90)
        ];
    }

    public function forWarehouse(Warehouse $warehouse)
    {
        return $this->state([
            'warehouse_id' => $warehouse->id
        ]);
    }

    public function active()
    {
        return $this->state([
            'is_active' => true
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'is_active' => false
        ]);
    }
}
