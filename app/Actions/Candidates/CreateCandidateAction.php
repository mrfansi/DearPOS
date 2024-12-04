<?php

namespace App\Actions\Candidates;

use App\Models\Candidate;
use Illuminate\Support\Str;

class CreateCandidateAction
{
    public function execute(array $data): Candidate
    {
        return Candidate::create([
            'id' => Str::uuid(),
            'job_posting_id' => $data['job_posting_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'resume_path' => $data['resume_path'] ?? null,
            'cover_letter_path' => $data['cover_letter_path'] ?? null,
            'status' => $data['status'] ?? 'applied',
            'interview_date' => $data['interview_date'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 