<?php

namespace App\Actions\Currencies;

use App\Models\Currency;
use Illuminate\Support\Str;

class CreateCurrencyAction
{
    public function execute(array $data): Currency
    {
        return Currency::create([
            'id' => Str::uuid(),
            'code' => $data['code'],
            'name' => $data['name'],
            'exchange_rate' => $data['exchange_rate']
        ]);
    }
} 