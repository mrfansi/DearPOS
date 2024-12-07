<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    public function run(): void
    {
        $leaveTypes = [
            [
                'name' => 'Annual Leave',
                'description' => 'Paid time off for vacation or personal reasons',
                'default_days' => 14,
                'is_accumulative' => true,
                'is_paid' => true,
                'requires_approval' => true
            ],
            [
                'name' => 'Sick Leave',
                'description' => 'Time off for medical reasons or personal illness',
                'default_days' => 10,
                'is_accumulative' => false,
                'is_paid' => true,
                'requires_approval' => false
            ],
            [
                'name' => 'Maternity Leave',
                'description' => 'Paid leave for new mothers',
                'default_days' => 90,
                'is_accumulative' => false,
                'is_paid' => true,
                'requires_approval' => true
            ],
            [
                'name' => 'Paternity Leave',
                'description' => 'Paid leave for new fathers',
                'default_days' => 14,
                'is_accumulative' => false,
                'is_paid' => true,
                'requires_approval' => true
            ],
            [
                'name' => 'Bereavement Leave',
                'description' => 'Time off for grieving and attending funeral services',
                'default_days' => 5,
                'is_accumulative' => false,
                'is_paid' => true,
                'requires_approval' => false
            ],
            [
                'name' => 'Unpaid Leave',
                'description' => 'Leave without pay for personal reasons',
                'default_days' => 0,
                'is_accumulative' => false,
                'is_paid' => false,
                'requires_approval' => true
            ],
            [
                'name' => 'Study Leave',
                'description' => 'Time off for educational purposes',
                'default_days' => 10,
                'is_accumulative' => false,
                'is_paid' => true,
                'requires_approval' => true
            ]
        ];

        foreach ($leaveTypes as $typeData) {
            LeaveType::create($typeData);
        }

        // Add some additional random leave types
        LeaveType::factory()->count(3)->create();
    }
}
