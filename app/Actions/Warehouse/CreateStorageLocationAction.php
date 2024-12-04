<?php

namespace App\Actions\Warehouse;

use App\Models\StorageLocation;

class CreateStorageLocationAction
{
    public function execute(array $data): StorageLocation
    {
        return StorageLocation::create([
            'warehouse_id' => $data['warehouse_id'],
            'name' => $data['name'],
            'code' => $data['code'],
            'type' => $data['type'] ?? 'standard', // standard, cold_storage, hazardous
            'capacity' => $data['capacity'] ?? null,
            'is_active' => $data['is_active'] ?? true,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 