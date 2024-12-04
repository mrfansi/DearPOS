<?php

namespace App\Actions\Payments;

use App\Models\DownPaymentConfig;
use Illuminate\Support\Str;

class CreateDownPaymentConfigAction
{
    public function execute(array $data): DownPaymentConfig
    {
        return DownPaymentConfig::create([
            'id' => Str::uuid(),
            'name' => $data['name'],
            'minimum_percentage' => $data['minimum_percentage'],
            'maximum_percentage' => $data['maximum_percentage'],
            'default_percentage' => $data['default_percentage'],
            'is_mandatory' => $data['is_mandatory'] ?? false,
            'description' => $data['description'] ?? null
        ]);
    }
} 