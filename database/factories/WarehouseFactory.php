<?php

namespace Database\Factories;

use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class WarehouseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Warehouse::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'name' => $this->faker->company,
            'code' => strtoupper($this->faker->unique()->lexify('WH??')),
            'address' => $this->faker->address,
            'contact_person' => $this->faker->name,
            'contact_phone' => $this->faker->phoneNumber,
            'location_id' => $this->faker->optional()->uuid,
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
