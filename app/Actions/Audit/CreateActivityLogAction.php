<?php

namespace App\Actions\Audit;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

class CreateActivityLogAction
{
    public function execute(array $data): ActivityLog
    {
        return ActivityLog::create([
            'id' => Str::uuid(),
            'user_id' => $data['user_id'] ?? null,
            'activity_type' => $data['activity_type'],
            'module' => $data['module'],
            'description' => $data['description'],
            'properties' => $data['properties'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);
    }
} 