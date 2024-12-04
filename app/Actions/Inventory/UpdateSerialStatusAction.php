<?php

namespace App\Actions\Inventory;

use App\Models\InventorySerial;

class UpdateSerialStatusAction
{
    public function execute(InventorySerial $serial, string $status): InventorySerial
    {
        $serial->update([
            'status' => $status
        ]);

        return $serial->fresh();
    }
} 