<?php

namespace App\Actions\Branches;

use App\Models\Branch;
use Illuminate\Support\Str;

class CreateBranchAction
{
    public function execute(array $data): Branch
    {
        return Branch::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'code' => $data['code'],
            'address' => $data['address'] ?? null,
            'phone' => $data['phone'] ?? null,
            'email' => $data['email'] ?? null,
            'company_id' => $data['company_id'],
            'location_id' => $data['location_id'],
            'is_active' => $data['is_active'] ?? true
        ]);
    }
} 