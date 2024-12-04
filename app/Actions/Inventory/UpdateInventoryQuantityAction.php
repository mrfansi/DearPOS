<?php

namespace App\Actions\Inventory;

use App\Models\ProductInventory;

class UpdateInventoryQuantityAction
{
    public function execute(ProductInventory $inventory, float $quantity, string $operation = 'add'): ProductInventory
    {
        if ($operation === 'add') {
            $inventory->increment('quantity', $quantity);
            $inventory->increment('available_quantity', $quantity);
        } else {
            $inventory->decrement('quantity', $quantity);
            $inventory->decrement('available_quantity', $quantity);
        }

        return $inventory->fresh();
    }
} 