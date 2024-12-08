<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\Location;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class WarehouseFactory extends Factory
{
    protected $model = Warehouse::class;

    public function definition(): array
    {
        $location = Location::factory()->create();
        $manager = Employee::factory()->create();

        return [
            'name' => $this->faker->company().' Warehouse',
            'code' => 'WH-'.strtoupper(substr(uniqid(), -8)),
            'location_id' => $location->id,
            'manager_id' => $manager->id,
            'is_active' => $this->faker->boolean(90),
            'notes' => $this->faker->optional()->sentence,
        ];
    }

    public function withLocation(Location $location)
    {
        return $this->state([
            'location_id' => $location->id,
        ]);
    }

    public function withManager(Employee $manager)
    {
        return $this->state([
            'manager_id' => $manager->id,
        ]);
    }

    public function active()
    {
        return $this->state([
            'is_active' => true,
        ]);
    }

    public function inactive()
    {
        return $this->state([
            'is_active' => false,
        ]);
    }
}
