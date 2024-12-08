<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
            'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{2}'),
            'description' => $this->faker->optional()->paragraph,
            'parent_id' => null,
            'manager_id' => null,
            'is_active' => $this->faker->boolean(90),
        ];
    }

    public function withParent(Department $parentDepartment)
    {
        return $this->state([
            'parent_id' => $parentDepartment->id,
        ]);
    }

    public function withManager(Employee $manager)
    {
        return $this->state([
            'manager_id' => $manager->id,
        ]);
    }
}
