<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Supplier::class;

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
            'code' => strtoupper($this->faker->unique()->lexify('SUP??')),
            'address' => $this->faker->address,
            'contact_person' => $this->faker->name,
            'contact_email' => $this->faker->unique()->safeEmail,
            'contact_phone' => $this->faker->phoneNumber,
            'currency_id' => $this->faker->optional()->uuid,
            'tax_number' => $this->faker->numerify('TAX#####'),
            'is_active' => $this->faker->boolean,
            'notes' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
