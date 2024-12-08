<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        // Create top-level departments
        $departments = [
            [
                'name' => 'Executive',
                'code' => 'EXEC',
                'description' => 'Top-level management and strategic planning',
                'is_active' => true,
                'sub_departments' => [
                    [
                        'name' => 'CEO Office',
                        'code' => 'CEO',
                        'description' => 'Chief Executive Officer\'s direct team',
                    ],
                    [
                        'name' => 'Board of Directors',
                        'code' => 'BOD',
                        'description' => 'Governance and strategic oversight',
                    ],
                ],
            ],
            [
                'name' => 'Human Resources',
                'code' => 'HR',
                'description' => 'Employee management and organizational development',
                'is_active' => true,
                'sub_departments' => [
                    [
                        'name' => 'Recruitment',
                        'code' => 'RECRUIT',
                        'description' => 'Talent acquisition and hiring',
                    ],
                    [
                        'name' => 'Training & Development',
                        'code' => 'T&D',
                        'description' => 'Employee training and skill development',
                    ],
                    [
                        'name' => 'Employee Relations',
                        'code' => 'ER',
                        'description' => 'Managing employee engagement and conflicts',
                    ],
                ],
            ],
            [
                'name' => 'Finance',
                'code' => 'FIN',
                'description' => 'Financial management and accounting',
                'is_active' => true,
                'sub_departments' => [
                    [
                        'name' => 'Accounting',
                        'code' => 'ACC',
                        'description' => 'Financial reporting and bookkeeping',
                    ],
                    [
                        'name' => 'Payroll',
                        'code' => 'PAYROLL',
                        'description' => 'Employee compensation and benefits',
                    ],
                    [
                        'name' => 'Financial Planning',
                        'code' => 'FP',
                        'description' => 'Strategic financial forecasting',
                    ],
                ],
            ],
            [
                'name' => 'Operations',
                'code' => 'OPS',
                'description' => 'Day-to-day business operations',
                'is_active' => true,
                'sub_departments' => [
                    [
                        'name' => 'Production',
                        'code' => 'PROD',
                        'description' => 'Manufacturing and production management',
                    ],
                    [
                        'name' => 'Logistics',
                        'code' => 'LOG',
                        'description' => 'Supply chain and distribution',
                    ],
                    [
                        'name' => 'Quality Control',
                        'code' => 'QC',
                        'description' => 'Product and service quality assurance',
                    ],
                ],
            ],
            [
                'name' => 'Technology',
                'code' => 'TECH',
                'description' => 'Information technology and digital infrastructure',
                'is_active' => true,
                'sub_departments' => [
                    [
                        'name' => 'Software Development',
                        'code' => 'DEV',
                        'description' => 'Application and software engineering',
                    ],
                    [
                        'name' => 'IT Support',
                        'code' => 'IT-SUP',
                        'description' => 'Technical support and infrastructure',
                    ],
                    [
                        'name' => 'Cybersecurity',
                        'code' => 'CYBER',
                        'description' => 'Network and data security',
                    ],
                ],
            ],
        ];

        foreach ($departments as $deptData) {
            $parentDepartment = Department::factory()->create([
                'name' => $deptData['name'],
                'code' => $deptData['code'],
                'description' => $deptData['description'],
                'is_active' => $deptData['is_active'] ?? true,
            ]);

            // Create sub-departments
            if (isset($deptData['sub_departments'])) {
                foreach ($deptData['sub_departments'] as $subDeptData) {
                    Department::factory()->create([
                        'name' => $subDeptData['name'],
                        'code' => $subDeptData['code'],
                        'description' => $subDeptData['description'],
                        'parent_id' => $parentDepartment->id,
                        'is_active' => true,
                    ]);
                }
            }
        }
    }
}
