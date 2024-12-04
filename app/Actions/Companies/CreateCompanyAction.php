<?php

namespace App\Actions\Companies;

use App\Models\Company;
use Illuminate\Support\Str;

class CreateCompanyAction
{
    public function execute(array $data): Company
    {
        return Company::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'code' => $data['code'],
            'address' => $data['address'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'tax_id' => $data['tax_id'] ?? null,
            'primary_currency_id' => $data['primary_currency_id'],
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 