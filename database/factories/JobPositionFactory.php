<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPositionFactory extends Factory
{
    protected $model = JobPosition::class;

    public function definition(): array
    {
        return [
            'department_id' => Department::factory(),
            'title' => $this->faker->jobTitle,
            'code' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{3}'),
            'description' => $this->faker->optional()->paragraph,
            'is_active' => $this->faker->boolean(90)
        ];
    }

    public function withDepartment(Department $department)
    {
        return $this->state([
            'department_id' => $department->id
        ]);
    }
}
