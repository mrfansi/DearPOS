<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user first
        $adminUser = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create admin employee
        Employee::factory()->create([
            'user_id' => $adminUser->id,
            'status' => 'active',
        ]);

        // Create regular employees (reduced from default to 10)
        $users = [];
        $employees = [];
        $defaultPassword = Hash::make('password');
        
        // Generate 10 users and employees
        for ($i = 0; $i < 10; $i++) {
            $userData = User::factory()->make()->toArray();
            $userData['id'] = fake()->uuid();
            $userData['password'] = $defaultPassword;
            // Format email_verified_at to MySQL datetime format
            $userData['email_verified_at'] = now()->format('Y-m-d H:i:s');
            $users[] = $userData;
            
            $employeeData = Employee::factory()->make([
                'user_id' => $userData['id'],
                'status' => fake()->randomElement(['active', 'on_leave', 'suspended']), // Exclude 'terminated' for active employees
            ])->toArray();
            
            // Add id for employee
            $employeeData['id'] = fake()->uuid();
            
            // Format dates to MySQL format
            foreach (['birth_date', 'hire_date', 'contract_start_date', 'contract_end_date', 'termination_date'] as $dateField) {
                if (isset($employeeData[$dateField]) && $employeeData[$dateField]) {
                    $employeeData[$dateField] = \Carbon\Carbon::parse($employeeData[$dateField])->format('Y-m-d H:i:s');
                }
            }
            
            $employees[] = $employeeData;
        }

        // Bulk insert users and employees
        DB::table('users')->insert($users);
        DB::table('employees')->insert($employees);
    }
}
