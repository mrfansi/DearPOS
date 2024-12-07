<?php

namespace Database\Factories;

use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Location>
 */
class LocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Location::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->lexify('LOC-????')),
            'name' => fake()->company(),
            'address' => fake()->address(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'country' => fake()->country(),
            'postal_code' => fake()->postcode(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->companyEmail(),
            'is_active' => fake()->boolean(80),
        ];
    }

    /**
     * Indicate that the location is a store.
     */
    public function asStore(): static
    {
        return $this->state([
            'type' => 'store',
        ]);
    }

    /**
     * Indicate that the location is a warehouse.
     */
    public function asWarehouse(): static
    {
        return $this->state([
            'type' => 'warehouse',
        ]);
    }

    /**
     * Set the parent location for this location.
     */
    public function withParent(string $parentId): static
    {
        return $this->state([
            'parent_location_id' => $parentId,
        ]);
    }
}
