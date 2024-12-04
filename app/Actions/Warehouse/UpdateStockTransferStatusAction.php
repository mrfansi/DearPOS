<?php

namespace App\Actions\Warehouse;

use App\Models\StockTransfer;

class UpdateStockTransferStatusAction
{
    public function execute(StockTransfer $transfer, string $status, ?string $approvedBy = null): StockTransfer
    {
        $updateData = ['status' => $status];
        
        if ($status === 'approved' && $approvedBy) {
            $updateData['approved_by'] = $approvedBy;
        }

        $transfer->update($updateData);

        return $transfer->fresh();
    }
} 