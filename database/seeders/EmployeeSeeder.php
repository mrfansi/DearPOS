<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\JobPosition;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Create predefined key employees
        $keyEmployees = [
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john.doe@company.com',
                'department_code' => 'EXEC',
                'position_title' => 'Chief Executive Officer',
                'status' => 'active'
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane.smith@company.com',
                'department_code' => 'HR',
                'position_title' => 'HR Director',
                'status' => 'active'
            ],
            [
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'email' => 'michael.johnson@company.com',
                'department_code' => 'FIN',
                'position_title' => 'Chief Financial Officer',
                'status' => 'active'
            ],
            [
                'first_name' => 'Emily',
                'last_name' => 'Brown',
                'email' => 'emily.brown@company.com',
                'department_code' => 'TECH',
                'position_title' => 'Chief Technology Officer',
                'status' => 'active'
            ],
            [
                'first_name' => 'David',
                'last_name' => 'Wilson',
                'email' => 'david.wilson@company.com',
                'department_code' => 'OPS',
                'position_title' => 'Chief Operating Officer',
                'status' => 'active'
            ]
        ];

        foreach ($keyEmployees as $employeeData) {
            // Find department and position
            $department = Department::where('code', $employeeData['department_code'])->first();
            $position = JobPosition::where('title', $employeeData['position_title'])->first();

            if ($department && $position) {
                // Create user
                $user = User::create([
                    'name' => $employeeData['first_name'] . ' ' . $employeeData['last_name'],
                    'email' => $employeeData['email'],
                    'password' => Hash::make('password'), // Default password
                    'email_verified_at' => now()
                ]);

                // Create employee
                $employee = Employee::create([
                    'user_id' => $user->id,
                    'department_id' => $department->id,
                    'position_id' => $position->id,
                    'employee_code' => 'EMP-' . strtoupper(substr($employeeData['first_name'], 0, 1) . substr($employeeData['last_name'], 0, 1) . rand(100, 999)),
                    'first_name' => $employeeData['first_name'],
                    'last_name' => $employeeData['last_name'],
                    'email' => $employeeData['email'],
                    'hire_date' => now(),
                    'status' => $employeeData['status']
                ]);

                // Update department manager if it's a director/executive
                if (strpos($position->title, 'Director') !== false || strpos($position->title, 'Chief') !== false) {
                    $department->update(['manager_id' => $employee->id]);
                }
            }
        }

        // Create additional random employees
        Employee::factory()->count(50)->create();
    }
}
