<?php

namespace App\Actions\Loyalty;

use App\Models\LoyaltyTransaction;
use Illuminate\Support\Str;

class CreateLoyaltyTransactionAction
{
    public function execute(array $data): LoyaltyTransaction
    {
        return LoyaltyTransaction::create([
            'id' => Str::uuid(),
            'customer_id' => $data['customer_id'],
            'points' => $data['points'],
            'source_type' => $data['source_type'],
            'description' => $data['description'],
            'status' => $data['status'] ?? 'active'
        ]);
    }
} 