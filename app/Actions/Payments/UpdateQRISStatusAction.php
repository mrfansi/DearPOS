<?php

namespace App\Actions\Payments;

use App\Models\QRISTransaction;

class UpdateQRISStatusAction
{
    public function execute(QRISTransaction $transaction, string $status): QRISTransaction
    {
        $transaction->update([
            'status' => $status
        ]);

        return $transaction->fresh();
    }
} 