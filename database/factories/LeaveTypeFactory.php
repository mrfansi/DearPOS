<?php

namespace Database\Factories;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    protected $model = LeaveType::class;

    public function definition(): array
    {
        return [
            'name' => $this->generateLeaveName(),
            'description' => $this->faker->optional()->paragraph,
            'default_days' => $this->faker->numberBetween(5, 30),
            'is_accumulative' => $this->faker->boolean(50),
            'is_paid' => $this->faker->boolean(80),
            'requires_approval' => $this->faker->boolean(90),
            'is_active' => $this->faker->boolean(90)
        ];
    }

    public function annual()
    {
        return $this->state([
            'name' => 'Annual Leave',
            'description' => 'Paid time off for vacation or personal reasons',
            'default_days' => 14,
            'is_accumulative' => true,
            'is_paid' => true,
            'requires_approval' => true
        ]);
    }

    public function sick()
    {
        return $this->state([
            'name' => 'Sick Leave',
            'description' => 'Time off for medical reasons or personal illness',
            'default_days' => 10,
            'is_accumulative' => false,
            'is_paid' => true,
            'requires_approval' => false
        ]);
    }

    public function unpaid()
    {
        return $this->state([
            'name' => 'Unpaid Leave',
            'description' => 'Leave without pay',
            'default_days' => 0,
            'is_accumulative' => false,
            'is_paid' => false,
            'requires_approval' => true
        ]);
    }

    private function generateLeaveName()
    {
        $leaveTypes = [
            'Vacation Leave',
            'Personal Leave',
            'Maternity Leave',
            'Paternity Leave',
            'Bereavement Leave',
            'Study Leave',
            'Compensatory Leave'
        ];

        return $this->faker->unique()->randomElement($leaveTypes);
    }
}
