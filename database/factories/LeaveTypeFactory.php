<?php

namespace Database\Factories;

use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeaveTypeFactory extends Factory
{
    protected $model = LeaveType::class;

    public function definition(): array
    {
        $name = $this->generateLeaveName();
        return [
            'name' => $name,
            'code' => $this->generateLeaveCode($name),
            'description' => $this->faker->optional()->paragraph,
            'default_days' => $this->faker->numberBetween(5, 30),
            'is_paid' => $this->faker->boolean(80),
            'is_active' => $this->faker->boolean(90)
        ];
    }

    public function annual()
    {
        return $this->state([
            'name' => 'Annual Leave',
            'code' => 'AL',
            'description' => 'Paid time off for vacation or personal reasons',
            'default_days' => 14,
            'is_paid' => true
        ]);
    }

    public function sick()
    {
        return $this->state([
            'name' => 'Sick Leave',
            'code' => 'SL',
            'description' => 'Time off for medical reasons or personal illness',
            'default_days' => 10,
            'is_paid' => true
        ]);
    }

    public function unpaid()
    {
        return $this->state([
            'name' => 'Unpaid Leave',
            'code' => 'UL',
            'description' => 'Leave without pay',
            'default_days' => 0,
            'is_paid' => false
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
            'Compensatory Leave',
            'Sabbatical Leave',
            'Family Care Leave',
            'Professional Development Leave'
        ];

        return $this->faker->randomElement($leaveTypes) . ' ' . $this->faker->randomNumber(3);
    }

    private function generateLeaveCode($name)
    {
        $predefinedCodes = ['AL', 'SL', 'UL', 'ML', 'PL'];
        
        do {
            // Generate a code with 2 letters and a UUID-like suffix
            $code = strtoupper(substr($name, 0, 2)) . substr(uniqid(), -4);
        } while (in_array($code, $predefinedCodes));

        return $code;
    }
}
