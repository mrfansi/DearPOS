<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\PerformanceReview;
use Illuminate\Database\Seeder;

class PerformanceReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Get all active employees
        $employees = Employee::where('status', 'active')->get();

        foreach ($employees as $employee) {
            // Create multiple performance reviews for each employee
            $this->createPerformanceReviews($employee);
        }

        // Add some additional random performance reviews
        PerformanceReview::factory()->count(20)->create();
    }

    private function createPerformanceReviews(Employee $employee)
    {
        // Quarterly reviews for the past year
        $quarterlyReviews = [
            ['period' => 'quarterly', 'date' => now()->subMonths(3)],
            ['period' => 'quarterly', 'date' => now()->subMonths(6)],
            ['period' => 'quarterly', 'date' => now()->subMonths(9)],
            ['period' => 'quarterly', 'date' => now()->subMonths(12)]
        ];

        // Annual review
        $annualReview = [
            'period' => 'annual', 
            'date' => now()->subYear(),
            'is_final' => true
        ];

        // Create reviews with different managers
        $managers = Employee::whereHas('managedDepartments')->get();

        foreach ($quarterlyReviews as $reviewData) {
            $manager = $managers->random();

            PerformanceReview::create([
                'employee_id' => $employee->id,
                'reviewer_id' => $manager->id,
                'review_date' => $reviewData['date'],
                'review_period' => $reviewData['period'],
                'overall_rating' => $this->generateRandomRating(),
                'strengths' => $this->generateStrengths(),
                'areas_for_improvement' => $this->generateAreasForImprovement(),
                'goals_for_next_period' => $this->generateGoals(),
                'is_final' => false
            ]);
        }

        // Create annual review
        $annualManager = $managers->random();
        PerformanceReview::create([
            'employee_id' => $employee->id,
            'reviewer_id' => $annualManager->id,
            'review_date' => $annualReview['date'],
            'review_period' => $annualReview['period'],
            'overall_rating' => $this->generateRandomRating(),
            'strengths' => $this->generateStrengths(),
            'areas_for_improvement' => $this->generateAreasForImprovement(),
            'goals_for_next_period' => $this->generateGoals(),
            'is_final' => true
        ]);
    }

    private function generateRandomRating()
    {
        $ratings = [
            'needs_improvement', 
            'meets_expectations', 
            'exceeds_expectations', 
            'outstanding'
        ];

        return $ratings[array_rand($ratings)];
    }

    private function generateStrengths()
    {
        $strengths = [
            'Strong communication skills',
            'Excellent problem-solving abilities',
            'Consistently meets deadlines',
            'Shows leadership potential',
            'Innovative thinking',
            'Team player',
            'Technical expertise',
            'Customer-focused approach'
        ];

        $numberOfStrengths = rand(2, 4);
        return implode("\n", array_slice($strengths, 0, $numberOfStrengths));
    }

    private function generateAreasForImprovement()
    {
        $improvements = [
            'Time management',
            'Advanced technical skills',
            'Public speaking',
            'Strategic planning',
            'Project management',
            'Cross-departmental collaboration',
            'Presentation skills'
        ];

        $numberOfImprovements = rand(1, 3);
        return implode("\n", array_slice($improvements, 0, $numberOfImprovements));
    }

    private function generateGoals()
    {
        $goals = [
            'Complete advanced certification',
            'Lead a cross-functional project',
            'Improve team productivity',
            'Develop new technical skills',
            'Mentor junior team members',
            'Implement process improvements',
            'Increase customer satisfaction'
        ];

        $numberOfGoals = rand(2, 4);
        return implode("\n", array_slice($goals, 0, $numberOfGoals));
    }
}
