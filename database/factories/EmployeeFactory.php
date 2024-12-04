<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'employee_number' => $this->faker->unique()->numerify('EMP###'),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'phone_number' => $this->faker->phoneNumber,
            'birth_date' => $this->faker->date(),
            'gender' => $this->faker->randomElement(['male', 'female', 'other']),
            'department_id' => $this->faker->optional()->uuid,
            'position_id' => $this->faker->optional()->uuid,
            'hire_date' => $this->faker->date(),
            'employment_status' => $this->faker->randomElement(['active', 'on_leave', 'terminated']),
            'resignation_date' => $this->faker->optional()->date(),
            'notes' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
