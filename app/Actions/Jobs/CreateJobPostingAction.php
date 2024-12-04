<?php

namespace App\Actions\Jobs;

use App\Models\JobPosting;

class CreateJobPostingAction
{
    public function execute(array $data): JobPosting
    {
        return JobPosting::create([
            'title' => $data['title'],
            'department_id' => $data['department_id'] ?? null,
            'position_id' => $data['position_id'] ?? null,
            'description' => $data['description'],
            'requirements' => $data['requirements'],
            'status' => $data['status'] ?? 'open',
            'posted_date' => $data['posted_date'] ?? now(),
            'closing_date' => $data['closing_date'] ?? null
        ]);
    }
} 