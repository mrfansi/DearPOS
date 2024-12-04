<?php

namespace App\Actions\Warehouse;

use App\Models\ReceivingItem;

class CreateReceivingItemAction
{
    public function execute(array $data): ReceivingItem
    {
        return ReceivingItem::create([
            'receiving_id' => $data['receiving_id'],
            'purchase_order_item_id' => $data['purchase_order_item_id'],
            'product_id' => $data['product_id'],
            'variant_id' => $data['variant_id'] ?? null,
            'quantity_ordered' => $data['quantity_ordered'],
            'quantity_received' => $data['quantity_received'],
            'unit_id' => $data['unit_id'],
            'batch_number' => $data['batch_number'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'storage_location_id' => $data['storage_location_id'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 