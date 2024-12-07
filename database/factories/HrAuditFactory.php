<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\HrAudit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class HrAuditFactory extends Factory
{
    protected $model = HrAudit::class;

    public function definition(): array
    {
        $modelTypes = [
            'Employee', 
            'Department', 
            'JobPosition', 
            'LeaveRequest', 
            'PerformanceReview'
        ];

        $actions = [
            'create', 
            'update', 
            'delete', 
            'restore', 
            'force_delete'
        ];

        $modelType = $this->faker->randomElement($modelTypes);
        $action = $this->faker->randomElement($actions);

        return [
            'employee_id' => $this->faker->optional()->passthrough(
                Employee::factory()->create()->id
            ),
            'user_id' => User::factory()->create()->id,
            'action' => $action,
            'model_type' => 'App\\Models\\' . $modelType,
            'model_id' => Str::uuid(),
            'old_values' => $this->faker->optional()->passthrough(
                json_encode($this->generateModelValues($modelType, 'old'))
            ),
            'new_values' => $this->faker->optional()->passthrough(
                json_encode($this->generateModelValues($modelType, 'new'))
            ),
            'reason' => $this->faker->optional()->sentence,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (HrAudit $audit) {
            // Optional post-creation logic
        });
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id
        ]);
    }

    public function createAudit()
    {
        return $this->state([
            'action' => 'create'
        ]);
    }

    public function updateAudit()
    {
        return $this->state([
            'action' => 'update',
            'old_values' => json_encode($this->generateModelValues('Employee', 'old')),
            'new_values' => json_encode($this->generateModelValues('Employee', 'new'))
        ]);
    }

    private function generateModelValues($modelType, $type)
    {
        return match($modelType) {
            'Employee' => $type === 'old' 
                ? ['name' => $this->faker->name, 'email' => $this->faker->email]
                : ['name' => $this->faker->name, 'email' => $this->faker->email, 'department' => $this->faker->word],
            'Department' => $type === 'old'
                ? ['name' => $this->faker->word, 'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{2}')]
                : ['name' => $this->faker->word, 'code' => $this->faker->unique()->regexify('[A-Z]{3}[0-9]{2}'), 'manager' => $this->faker->name],
            default => []
        };
    }
}
