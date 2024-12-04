<?php

namespace App\Actions\Inventory;

use App\Models\InventorySerial;
use Illuminate\Support\Str;

class CreateInventorySerialAction
{
    public function execute(array $data): InventorySerial
    {
        return InventorySerial::create([
            'id' => Str::uuid(),
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? null,
            'lot_id' => $data['lot_id'] ?? null,
            'serial_number' => $data['serial_number'],
            'status' => $data['status'] ?? 'available'
        ]);
    }
} 