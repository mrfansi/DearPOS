<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

class LeaveRequestFactory extends Factory
{
    protected $model = LeaveRequest::class;

    public function definition(): array
    {
        $startDate = $this->faker->dateTimeBetween('-6 months', '+6 months');
        $endDate = Carbon::parse($startDate)->addDays($this->faker->numberBetween(1, 10));
        $daysRequested = Carbon::parse($startDate)->diffInDays($endDate) + 1;

        $employee = Employee::factory()->create();
        $leaveType = LeaveType::factory()->create();

        return [
            'employee_id' => $employee->id,
            'leave_type_id' => $leaveType->id,
            'approved_by' => $this->faker->optional()->passthrough(Employee::factory()->create()->id),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'days_requested' => $daysRequested,
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'cancelled']),
            'reason' => $this->faker->sentence,
            'notes' => $this->faker->optional()->sentence,
            'approved_at' => $this->faker->optional()->dateTimeBetween($startDate, $endDate)
        ];
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id
        ]);
    }

    public function withLeaveType(LeaveType $leaveType)
    {
        return $this->state([
            'leave_type_id' => $leaveType->id
        ]);
    }

    public function pending()
    {
        return $this->state([
            'status' => 'pending',
            'approved_at' => null
        ]);
    }

    public function approved()
    {
        return $this->state([
            'status' => 'approved',
            'approved_at' => now()
        ]);
    }

    public function rejected()
    {
        return $this->state([
            'status' => 'rejected',
            'notes' => $this->faker->paragraph
        ]);
    }
}
