<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\LeaveRequest;
use App\Models\LeaveType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaveRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Get active employees and leave types
        $employees = Employee::where('status', 'active')->limit(10)->get();
        $leaveTypes = LeaveType::all();

        $leaveRequests = [];
        $now = now();

        foreach ($employees as $employee) {
            // Create 2 leave requests per employee (reduced from previous amount)
            for ($i = 0; $i < 2; $i++) {
                $startDate = $now->copy()->addDays(rand(1, 30));
                $endDate = $startDate->copy()->addDays(rand(1, 5));
                
                $leaveRequests[] = [
                    'id' => fake()->uuid(),
                    'employee_id' => $employee->id,
                    'leave_type_id' => $leaveTypes->random()->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'days_requested' => $startDate->diffInDays($endDate) + 1,
                    'status' => fake()->randomElement(['pending', 'approved', 'rejected']),
                    'reason' => fake()->sentence(),
                    'notes' => fake()->optional()->paragraph(),
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        // Bulk insert all leave requests
        foreach (array_chunk($leaveRequests, 50) as $chunk) {
            DB::table('leave_requests')->insert($chunk);
        }
    }
}
