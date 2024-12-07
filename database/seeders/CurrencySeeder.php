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
                'exchange_rate' => 1,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'exchange_rate' => 0.93,
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound',
                'exchange_rate' => 0.79,
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'exchange_rate' => 149.50,
            ],
            [
                'code' => 'IDR',
                'name' => 'Indonesian Rupiah',
                'exchange_rate' => 15500,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::firstOrCreate(
                ['code' => $currency['code']],
                $currency
            );
        }
    }
}
