<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\PerformanceReview;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PerformanceReviewSeeder extends Seeder
{
    public function run(): void
    {
        $employees = Employee::all();

        foreach ($employees as $employee) {
            // Create 1-2 performance reviews per employee
            $numberOfReviews = rand(1, 2);

            for ($i = 0; $i < $numberOfReviews; $i++) {
                $reviewPeriodStart = Carbon::now()->subMonths(rand(3, 12));
                $reviewPeriodEnd = $reviewPeriodStart->copy()->addMonths(3);

                PerformanceReview::create([
                    'employee_id' => $employee->id,
                    'reviewer_id' => $employees->where('id', '!=', $employee->id)->random()->id,
                    'review_period_start' => $reviewPeriodStart,
                    'review_period_end' => $reviewPeriodEnd,
                    'overall_rating' => round(rand(10, 50) / 10, 1),
                    'strengths' => implode('. ', [
                        'Strong communication skills',
                        'Consistently meets project deadlines',
                        'Demonstrates leadership potential',
                        'Excellent problem-solving abilities'
                    ]),
                    'improvements' => implode('. ', [
                        'Needs to improve time management',
                        'Could benefit from additional technical training',
                        'Develop more proactive approach to team collaboration'
                    ]),
                    'goals' => implode('. ', [
                        'Complete advanced certification',
                        'Lead a cross-departmental project',
                        'Mentor junior team members',
                        'Improve technical skills in emerging technologies'
                    ]),
                    'status' => ['draft', 'in_progress', 'reviewed', 'finalized'][rand(0, 3)]
                ]);
            }
        }
    }
}
