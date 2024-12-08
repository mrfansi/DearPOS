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
                'code' => 'AL',
                'description' => 'Regular annual leave entitlement',
                'is_paid' => true,
                'default_days' => 12,
                'is_active' => true,
            ],
            [
                'name' => 'Sick Leave',
                'code' => 'SL',
                'description' => 'Leave for medical reasons',
                'is_paid' => true,
                'default_days' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'Unpaid Leave',
                'code' => 'UL',
                'description' => 'Leave without pay',
                'is_paid' => false,
                'default_days' => 0,
                'is_active' => true,
            ],
            [
                'name' => 'Maternity Leave',
                'code' => 'ML',
                'description' => 'Leave for new mothers',
                'is_paid' => true,
                'default_days' => 90,
                'is_active' => true,
            ],
            [
                'name' => 'Paternity Leave',
                'code' => 'PL',
                'description' => 'Leave for new fathers',
                'is_paid' => true,
                'default_days' => 14,
                'is_active' => true,
            ],
            [
                'name' => 'Bereavement Leave',
                'code' => 'BL',
                'description' => 'Leave for family loss',
                'is_paid' => true,
                'default_days' => 3,
                'is_active' => true,
            ],
        ];

        foreach ($leaveTypes as $leaveTypeData) {
            LeaveType::create($leaveTypeData);
        }
    }
}
