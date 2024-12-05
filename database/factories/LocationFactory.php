<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocationFactory extends Factory
{
    protected $model = Location::class;

    public function definition(): array
    {
        $types = ['store', 'warehouse', 'office', 'branch'];

        return [
            'name' => fake()->company(),
            'type' => fake()->randomElement($types),
            'address' => fake()->optional()->address(),
            'parent_location_id' => null,
        ];
    }

    public function store()
    {
        return $this->state([
            'type' => 'store',
        ]);
    }

    public function warehouse(): static
    {
        return $this->state([
            'type' => 'warehouse',
        ]);
    }

    public function withParent(string $parentId): static
    {
        return $this->state([
            'parent_location_id' => $parentId,
        ]);
    }
}
