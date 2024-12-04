<?php

namespace App\Actions\Warehouse;

use App\Models\Receiving;

class UpdateReceivingStatusAction
{
    public function execute(Receiving $receiving, string $status, ?array $additionalData = []): Receiving
    {
        $updateData = ['status' => $status];
        
        if (isset($additionalData['notes'])) {
            $updateData['notes'] = $additionalData['notes'];
        }

        if ($status === 'completed') {
            $updateData['completed_at'] = now();
            $updateData['completed_by'] = $additionalData['completed_by'] ?? null;
        }

        $receiving->update($updateData);

        return $receiving->fresh();
    }
} 