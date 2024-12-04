<?php

namespace App\Actions\Inventory;

use App\Models\InventoryLot;
use Illuminate\Support\Str;

class CreateInventoryLotAction
{
    public function execute(array $data): InventoryLot
    {
        return InventoryLot::create([
            'id' => Str::uuid(),
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? null,
            'lot_number' => $data['lot_number'],
            'manufacturing_date' => $data['manufacturing_date'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null
        ]);
    }
} 