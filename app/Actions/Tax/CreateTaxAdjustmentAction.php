<?php

namespace App\Actions\Tax;

use App\Models\TaxAdjustment;

class CreateTaxAdjustmentAction
{
    public function execute(array $data): TaxAdjustment
    {
        return TaxAdjustment::create([
            'tax_return_id' => $data['tax_return_id'],
            'adjustment_type' => $data['adjustment_type'],
            'amount' => $data['amount'],
            'reason' => $data['reason'] ?? null,
            'reference_number' => $data['reference_number'] ?? null,
            'adjustment_date' => $data['adjustment_date'] ?? now()
        ]);
    }
} 