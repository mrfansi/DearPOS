<?php

namespace App\Actions\Warehouse;

use App\Models\StockTransfer;

class CreateStockTransferAction
{
    public function execute(array $data): StockTransfer
    {
        return StockTransfer::create([
            'from_warehouse_id' => $data['from_warehouse_id'],
            'to_warehouse_id' => $data['to_warehouse_id'],
            'transfer_date' => $data['transfer_date'] ?? now(),
            'status' => $data['status'] ?? 'pending',
            'notes' => $data['notes'] ?? null,
            'created_by' => $data['created_by'],
            'approved_by' => $data['approved_by'] ?? null
        ]);
    }
} 