<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory;
use Carbon\Carbon;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create();

        // Get all employees, leave types and users
        $employees = Employee::all();
        $leaveTypes = LeaveType::all();
        $approvers = User::all();

        foreach ($employees as $employee) {
            // Create 2-4 leave requests for each employee
            $numberOfRequests = $faker->numberBetween(2, 4);

            for ($i = 0; $i < $numberOfRequests; $i++) {
                // Generate start date between 6 months ago and 6 months from now
                $startDate = Carbon::now()->subMonths(6)->addDays($faker->numberBetween(0, 365));
                
                // Generate end date between 1 and 14 days after start date
                $endDate = $startDate->copy()->addDays($faker->numberBetween(1, 14));

                $status = $faker->randomElement(['pending', 'approved', 'rejected', 'cancelled']);

                $leaveRequest = LeaveRequest::factory()->create([
                    'employee_id' => $employee->id,
                    'leave_type_id' => $leaveTypes->random()->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'days_requested' => Carbon::parse($startDate)->diffInDays($endDate) + 1,
                    'reason' => $faker->sentence(),
                    'status' => $status,
                    'approved_by' => $status === 'approved' ? $approvers->random()->id : null,
                    'approved_at' => $status === 'approved' ? Carbon::parse($startDate)->subDays($faker->numberBetween(1, 7)) : null,
                    'notes' => $faker->optional()->sentence()
                ]);
            }
        }
    }
}
