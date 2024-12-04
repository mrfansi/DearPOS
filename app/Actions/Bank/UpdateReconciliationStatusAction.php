<?php

namespace App\Actions\Bank;

use App\Models\BankReconciliation;

class UpdateReconciliationStatusAction
{
    public function execute(BankReconciliation $reconciliation, string $status, string $userId): BankReconciliation
    {
        $updateData = [
            'status' => $status
        ];

        if ($status === 'completed') {
            $updateData = array_merge($updateData, [
                'completed_by' => $userId,
                'completed_at' => now()
            ]);
        }

        $reconciliation->update($updateData);

        return $reconciliation->fresh();
    }
} 