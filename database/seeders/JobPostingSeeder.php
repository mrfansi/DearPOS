<?php

namespace Database\Seeders;

use App\Models\JobPosition;
use App\Models\JobPosting;
use Illuminate\Database\Seeder;

class JobPostingSeeder extends Seeder
{
    public function run(): void
    {
        $jobPostings = [
            [
                'position_title' => 'Senior Software Engineer',
                'description' => 'We are seeking a talented and experienced Senior Software Engineer to join our dynamic technology team. The ideal candidate will have strong programming skills and experience in developing scalable software solutions.',
                'requirements' => '- Bachelors degree in Computer Science or related field
- 5+ years of software development experience
- Proficiency in PHP, Laravel, and JavaScript
- Experience with cloud technologies
- Strong problem-solving skills',
            ],
            [
                'position_title' => 'HR Recruitment Specialist',
                'description' => 'We are looking for a proactive and strategic HR Recruitment Specialist to help us attract and hire top talent. The successful candidate will play a crucial role in our talent acquisition process.',
                'requirements' => "- Bachelor's degree in Human Resources or related field
- 3+ years of recruitment experience
- Strong communication and interpersonal skills
- Proficiency in recruitment tools and platforms
- Ability to assess candidate potential",
            ],
            [
                'position_title' => 'Financial Analyst',
                'description' => 'We are seeking a detail-oriented Financial Analyst to support our financial planning and analysis team. The ideal candidate will have strong analytical skills and the ability to provide strategic financial insights.',
                'requirements' => "- Bachelor's degree in Finance, Accounting, or related field
- 2+ years of financial analysis experience
- Advanced Excel skills
- Understanding of financial modeling
- Strong analytical and problem-solving skills",
            ],
            [
                'position_title' => 'Quality Control Specialist',
                'description' => 'We are looking for a meticulous Quality Control Specialist to ensure the highest standards of product quality. The successful candidate will be responsible for implementing and maintaining quality control processes.',
                'requirements' => "- Bachelor's degree in Quality Management, Engineering, or related field
- 3+ years of quality control experience
- Knowledge of quality management systems
- Attention to detail
- Strong analytical skills",
            ],
            [
                'position_title' => 'Cybersecurity Analyst',
                'description' => "We are seeking a skilled Cybersecurity Analyst to protect our organization's digital assets and information systems. The ideal candidate will have a strong background in network security and threat detection.",
                'requirements' => "- Bachelor's degree in Cybersecurity, Computer Science, or related field
- 4+ years of cybersecurity experience
- Certifications like CISSP, CEH preferred
- Knowledge of security frameworks and protocols
- Strong problem-solving and analytical skills",
            ],
        ];

        foreach ($jobPostings as $postingData) {
            // Find a matching job position
            $jobPosition = JobPosition::where('title', 'like', '%'.$postingData['position_title'].'%')->first();

            if ($jobPosition) {
                JobPosting::create([
                    'position_id' => $jobPosition->id,
                    'title' => $postingData['position_title'],
                    'description' => $postingData['description'],
                    'requirements' => $postingData['requirements'],
                    'status' => 'open',
                    'posted_date' => now(),
                    'closing_date' => now()->addDays(30),
                ]);
            }
        }

        // Add some random job postings
        JobPosting::factory()->count(5)->create();
    }
}
