<?php

namespace App\Actions\Inventory;

use App\Models\InventoryLot;

class UpdateLotStatusAction
{
    public function execute(InventoryLot $lot, string $status): InventoryLot
    {
        $lot->update([
            'status' => $status,
            'expired_at' => $status === 'expired' ? now() : $lot->expired_at
        ]);

        return $lot->fresh();
    }
} 