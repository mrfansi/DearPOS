<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\JobPosition;
use Illuminate\Database\Seeder;

class JobPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positionData = [
            // Executive Positions
            [
                'department_code' => 'EXEC',
                'positions' => [
                    ['title' => 'Chief Executive Officer', 'code' => 'CEO-001'],
                    ['title' => 'Chief Financial Officer', 'code' => 'CFO-001'],
                    ['title' => 'Chief Operating Officer', 'code' => 'COO-001']
                ]
            ],
            // HR Positions
            [
                'department_code' => 'HR',
                'positions' => [
                    ['title' => 'HR Director', 'code' => 'HR-DIR-001'],
                    ['title' => 'Recruitment Manager', 'code' => 'HR-REC-001'],
                    ['title' => 'Training Specialist', 'code' => 'HR-TRN-001'],
                    ['title' => 'Employee Relations Coordinator', 'code' => 'HR-ER-001']
                ]
            ],
            // Finance Positions
            [
                'department_code' => 'FIN',
                'positions' => [
                    ['title' => 'Finance Manager', 'code' => 'FIN-MGR-001'],
                    ['title' => 'Accounting Specialist', 'code' => 'FIN-ACC-001'],
                    ['title' => 'Payroll Coordinator', 'code' => 'FIN-PAY-001'],
                    ['title' => 'Financial Analyst', 'code' => 'FIN-ANL-001']
                ]
            ],
            // Operations Positions
            [
                'department_code' => 'OPS',
                'positions' => [
                    ['title' => 'Operations Director', 'code' => 'OPS-DIR-001'],
                    ['title' => 'Production Manager', 'code' => 'OPS-PROD-001'],
                    ['title' => 'Logistics Coordinator', 'code' => 'OPS-LOG-001'],
                    ['title' => 'Quality Control Specialist', 'code' => 'OPS-QC-001']
                ]
            ],
            // Technology Positions
            [
                'department_code' => 'TECH',
                'positions' => [
                    ['title' => 'Chief Technology Officer', 'code' => 'CTO-001'],
                    ['title' => 'Senior Software Engineer', 'code' => 'DEV-SE-001'],
                    ['title' => 'IT Support Technician', 'code' => 'IT-SUP-001'],
                    ['title' => 'Cybersecurity Analyst', 'code' => 'CYBER-ANL-001']
                ]
            ]
        ];

        foreach ($positionData as $departmentPositions) {
            $department = Department::where('code', $departmentPositions['department_code'])->first();
            
            if ($department) {
                foreach ($departmentPositions['positions'] as $position) {
                    JobPosition::create([
                        'department_id' => $department->id,
                        'title' => $position['title'],
                        'code' => $position['code'],
                        'description' => "Responsible for {$position['title']} duties",
                        'is_active' => true
                    ]);
                }
            }
        }

        // Add some random job positions
        JobPosition::factory()->count(10)->create();
    }
}
