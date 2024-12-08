<?php

namespace Database\Factories;

use App\Models\JobPosition;
use App\Models\JobPosting;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobPostingFactory extends Factory
{
    protected $model = JobPosting::class;

    public function definition(): array
    {
        $postedDate = $this->faker->dateTimeBetween('-3 months', 'now');
        $closingDate = $this->faker->optional()->dateTimeBetween($postedDate, '+2 months');

        return [
            'position_id' => JobPosition::factory(),
            'title' => $this->faker->jobTitle,
            'description' => $this->faker->paragraphs(3, true),
            'requirements' => $this->faker->paragraphs(2, true),
            'status' => $this->faker->randomElement(['draft', 'open', 'closed', 'on_hold']),
            'posted_date' => $postedDate,
            'closing_date' => $closingDate,
        ];
    }

    public function withPosition(JobPosition $position)
    {
        return $this->state([
            'position_id' => $position->id,
        ]);
    }

    public function open()
    {
        return $this->state([
            'status' => 'open',
        ]);
    }

    public function closed()
    {
        return $this->state([
            'status' => 'closed',
        ]);
    }
}
