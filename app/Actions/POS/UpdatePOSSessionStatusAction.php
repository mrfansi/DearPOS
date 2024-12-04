<?php

namespace App\Actions\POS;

use App\Models\POSSession;

class UpdatePOSSessionStatusAction
{
    public function execute(POSSession $session, string $status, ?array $data = null): POSSession
    {
        $updateData = ['status' => $status];

        if ($status === 'closed') {
            $updateData = array_merge($updateData, [
                'closing_time' => now(),
                'actual_amount' => $data['actual_amount'] ?? 0,
                'difference_amount' => ($data['actual_amount'] ?? 0) - $session->expected_amount
            ]);
        }

        $session->update($updateData);

        return $session->fresh();
    }
} 