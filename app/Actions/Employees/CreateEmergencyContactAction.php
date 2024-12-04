<?php

namespace App\Actions\Employees;

use App\Models\EmergencyContact;
use Illuminate\Support\Str;

class CreateEmergencyContactAction
{
    public function execute(array $data): EmergencyContact
    {
        return EmergencyContact::create([
            'id' => Str::uuid(),
            'employee_id' => $data['employee_id'],
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'relationship' => $data['relationship'],
            'primary_phone' => $data['primary_phone'],
            'secondary_phone' => $data['secondary_phone'] ?? null,
            'email' => $data['email'] ?? null,
            'address' => $data['address'] ?? null,
            'is_primary_contact' => $data['is_primary_contact'] ?? false
        ]);
    }
} 