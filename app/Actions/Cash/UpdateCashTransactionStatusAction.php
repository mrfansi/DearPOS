<?php

namespace App\Actions\Cash;

use App\Models\CashManagement;

class UpdateCashTransactionStatusAction
{
    public function execute(CashManagement $transaction, string $status, ?string $notes = null): CashManagement
    {
        $transaction->update([
            'status' => $status,
            'notes' => $notes ?? $transaction->notes
        ]);

        return $transaction->fresh();
    }
} 