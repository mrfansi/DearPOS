<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'exchange_rate' => 1.0000,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'exchange_rate' => 0.9200,
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound',
                'exchange_rate' => 0.7900,
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'exchange_rate' => 110.0000,
            ],
            [
                'code' => 'IDR',
                'name' => 'Indonesian Rupiah',
                'exchange_rate' => 15500.0000,
            ],
            [
                'code' => 'SGD',
                'name' => 'Singapore Dollar',
                'exchange_rate' => 1.3500,
            ],
            [
                'code' => 'AUD',
                'name' => 'Australian Dollar',
                'exchange_rate' => 1.5200,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}
