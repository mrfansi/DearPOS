<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $firstName = $this->faker->firstName;
        $lastName = $this->faker->lastName;
        $email = strtolower($firstName.'.'.$lastName.'@'.$this->faker->domainName);

        return [
            'user_id' => User::factory(),
            'department_id' => Department::factory(),
            'position_id' => JobPosition::factory(),
            'employee_code' => $this->faker->unique()->regexify('EMP[0-9]{6}'),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $this->faker->optional()->phoneNumber,
            'mobile' => $this->faker->optional()->phoneNumber,
            'birth_date' => $this->faker->optional()->dateTimeBetween('-50 years', '-20 years'),
            'hire_date' => $hireDate = $this->faker->dateTimeBetween('-5 years', 'now'),
            'contract_start_date' => $hireDate,
            'contract_end_date' => $this->faker->optional()->dateTimeBetween($hireDate, '+3 years'),
            'termination_date' => null,
            'status' => $this->faker->randomElement(['active', 'on_leave', 'terminated', 'suspended']),
            'emergency_contact_name' => $this->faker->optional()->name,
            'emergency_contact_phone' => $this->faker->optional()->phoneNumber,
            'notes' => $this->faker->optional()->paragraph,
        ];
    }

    public function withDepartment(Department $department)
    {
        return $this->state([
            'department_id' => $department->id,
        ]);
    }

    public function withPosition(JobPosition $position)
    {
        return $this->state([
            'position_id' => $position->id,
        ]);
    }

    public function active()
    {
        return $this->state([
            'status' => 'active',
        ]);
    }

    public function terminated()
    {
        return $this->state([
            'status' => 'terminated',
            'termination_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }
}
