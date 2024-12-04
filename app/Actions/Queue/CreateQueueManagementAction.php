<?php

namespace App\Actions\Queue;

use App\Models\QueueManagement;
use Illuminate\Support\Str;

class CreateQueueManagementAction
{
    public function execute(array $data): QueueManagement
    {
        return QueueManagement::create([
            'id' => Str::uuid(),
            'queue_number' => $data['queue_number'],
            'customer_id' => $data['customer_id'] ?? null,
            'pos_counter_id' => $data['pos_counter_id'],
            'status' => $data['status'] ?? 'waiting',
            'priority' => $data['priority'] ?? 0,
            'estimated_wait_time' => $data['estimated_wait_time'] ?? null,
            'actual_wait_time' => $data['actual_wait_time'] ?? null,
            'notes' => $data['notes'] ?? null,
            'created_by' => $data['created_by']
        ]);
    }
} 