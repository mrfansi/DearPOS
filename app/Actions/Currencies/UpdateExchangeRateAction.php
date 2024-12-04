<?php

namespace App\Actions\Currencies;

use App\Models\Currency;

class UpdateExchangeRateAction
{
    public function execute(Currency $currency, float $newRate): Currency
    {
        $currency->update([
            'exchange_rate' => $newRate
        ]);

        return $currency->fresh();
    }
} 