<?php

namespace App\Actions\Tax;

use App\Models\TaxRate;

class CreateTaxRateAction
{
    public function execute(array $data): TaxRate
    {
        return TaxRate::create([
            'tax_category_id' => $data['tax_category_id'],
            'name' => $data['name'],
            'code' => $data['code'],
            'rate' => $data['rate'],
            'is_compound' => $data['is_compound'] ?? false,
            'is_active' => $data['is_active'] ?? true,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'notes' => $data['notes'] ?? null
        ]);
    }
} 