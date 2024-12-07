<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\EmployeeAddress;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeAddressFactory extends Factory
{
    protected $model = EmployeeAddress::class;

    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'address_type' => $this->faker->randomElement(['home', 'mailing', 'temporary']),
            'address_line_1' => $this->faker->streetAddress,
            'address_line_2' => $this->faker->optional()->secondaryAddress,
            'city' => $this->faker->city,
            'state' => $this->faker->state,
            'postal_code' => $this->faker->postcode,
            'country' => $this->faker->country,
            'is_current' => $this->faker->boolean(90)
        ];
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id
        ]);
    }

    public function home()
    {
        return $this->state([
            'address_type' => 'home',
            'is_current' => true
        ]);
    }

    public function mailing()
    {
        return $this->state([
            'address_type' => 'mailing'
        ]);
    }
}
