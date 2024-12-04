<?php

namespace App\Actions\Inventory;

use App\Models\InventoryAuditLog;
use Illuminate\Support\Str;

class CreateInventoryAuditAction
{
    public function execute(array $data): InventoryAuditLog
    {
        return InventoryAuditLog::create([
            'id' => Str::uuid(),
            'product_id' => $data['product_id'],
            'warehouse_id' => $data['warehouse_id'],
            'audit_date' => $data['audit_date'] ?? now(),
            'system_quantity' => $data['system_quantity'],
            'physical_quantity' => $data['physical_quantity'],
            'difference' => $data['physical_quantity'] - $data['system_quantity'],
            'status' => 'pending',
            'notes' => $data['notes'] ?? null,
            'audited_by' => $data['audited_by']
        ]);
    }
} 