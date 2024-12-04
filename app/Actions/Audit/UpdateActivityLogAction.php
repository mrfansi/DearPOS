<?php

namespace App\Actions\Audit;

use App\Models\ActivityLog;

class UpdateActivityLogAction
{
    public function execute(ActivityLog $log, array $properties): ActivityLog
    {
        $log->update([
            'properties' => array_merge($log->properties ?? [], $properties)
        ]);

        return $log->fresh();
    }
} 