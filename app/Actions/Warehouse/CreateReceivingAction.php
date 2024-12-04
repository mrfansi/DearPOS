<?php

namespace App\Actions\Warehouse;

use App\Models\Receiving;

class CreateReceivingAction
{
    public function execute(array $data): Receiving
    {
        return Receiving::create([
            'purchase_order_id' => $data['purchase_order_id'],
            'warehouse_id' => $data['warehouse_id'],
            'received_date' => $data['received_date'] ?? now(),
            'received_by' => $data['received_by'],
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null,
            'document_number' => $data['document_number'] ?? null,
            'supplier_delivery_number' => $data['supplier_delivery_number'] ?? null
        ]);
    }
} 