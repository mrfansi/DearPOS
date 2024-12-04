<?php

namespace App\Actions\Payments;

use App\Models\QRISTransaction;

class CreateQRISTransactionAction
{
    public function execute(array $data): QRISTransaction
    {
        return QRISTransaction::create([
            'transaction_id' => $data['transaction_id'],
            'qris_id' => $data['qris_id'],
            'amount' => $data['amount'],
            'status' => $data['status'] ?? 'pending',
            'expires_at' => $data['expires_at'] ?? now()->addMinutes(15)
        ]);
    }
} 