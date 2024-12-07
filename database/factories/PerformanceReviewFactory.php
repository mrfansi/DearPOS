<?php

namespace Database\Factories;

use App\Models\Employee;
use App\Models\PerformanceReview;
use Illuminate\Database\Eloquent\Factories\Factory;

class PerformanceReviewFactory extends Factory
{
    protected $model = PerformanceReview::class;

    public function definition(): array
    {
        $employee = Employee::factory()->create();
        $reviewer = Employee::factory()->create();

        return [
            'employee_id' => $employee->id,
            'reviewer_id' => $reviewer->id,
            'review_date' => $reviewDate = $this->faker->dateTimeBetween('-1 year', 'now'),
            'review_period' => $this->faker->randomElement(['quarterly', 'semi_annual', 'annual']),
            'overall_rating' => $this->faker->randomElement([
                'needs_improvement', 
                'meets_expectations', 
                'exceeds_expectations', 
                'outstanding'
            ]),
            'strengths' => $this->faker->paragraphs(2, true),
            'areas_for_improvement' => $this->faker->paragraphs(2, true),
            'goals_for_next_period' => $this->faker->paragraphs(2, true),
            'reviewer_comments' => $this->faker->optional()->paragraph,
            'is_final' => $this->faker->boolean(70)
        ];
    }

    public function withEmployee(Employee $employee)
    {
        return $this->state([
            'employee_id' => $employee->id
        ]);
    }

    public function withReviewer(Employee $reviewer)
    {
        return $this->state([
            'reviewer_id' => $reviewer->id
        ]);
    }

    public function quarterly()
    {
        return $this->state([
            'review_period' => 'quarterly'
        ]);
    }

    public function annual()
    {
        return $this->state([
            'review_period' => 'annual',
            'is_final' => true
        ]);
    }

    public function outstanding()
    {
        return $this->state([
            'overall_rating' => 'outstanding',
            'strengths' => $this->faker->paragraphs(3, true)
        ]);
    }
}
