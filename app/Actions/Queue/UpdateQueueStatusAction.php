<?php

namespace App\Actions\Queue;

use App\Models\QueueManagement;

class UpdateQueueStatusAction
{
    public function execute(QueueManagement $queue, string $status, ?string $notes = null): QueueManagement
    {
        $queue->update([
            'status' => $status,
            'notes' => $notes ?? $queue->notes,
            'actual_wait_time' => $status === 'completed' ? now()->diffInMinutes($queue->created_at) : null
        ]);

        return $queue->fresh();
    }
} 