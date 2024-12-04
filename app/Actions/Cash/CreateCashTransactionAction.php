<?php

namespace App\Actions\Cash;

use App\Models\CashManagement;
use Illuminate\Support\Str;

class CreateCashTransactionAction
{
    public function execute(array $data): CashManagement
    {
        return CashManagement::create([
            'id' => Str::uuid(),
            'session_id' => $data['session_id'],
            'employee_id' => $data['employee_id'],
            'transaction_type' => $data['transaction_type'],
            'amount' => $data['amount'],
            'reason' => $data['reason'] ?? null,
            'reference_number' => $data['reference_number'] ?? null
        ]);
    }
} 