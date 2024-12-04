<?php

namespace App\Actions\Inventory;

use App\Models\ExpiryAlert;
use Illuminate\Support\Str;

class CreateExpiryAlertAction
{
    public function execute(array $data): ExpiryAlert
    {
        return ExpiryAlert::create([
            'id' => Str::uuid(),
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? null,
            'lot_id' => $data['lot_id'] ?? null,
            'days_before_expiry' => $data['days_before_expiry'],
            'is_active' => $data['is_active'] ?? true,
            'last_triggered_at' => null,
            'created_by' => $data['created_by']
        ]);
    }
} 