<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\PosCounter;
use App\Models\SalesTransaction;
use Illuminate\Database\Seeder;

class SalesTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all active POS counters
        $posCounters = PosCounter::where('is_active', true)->get();

        // Get the default currency (USD or first available currency)
        $defaultCurrency = Currency::where('code', 'USD')->first() ?? Currency::first();

        // Create completed sales transactions
        SalesTransaction::factory()
            ->count(50)
            ->completed()
            ->recycle($posCounters)
            ->state([
                'currency_id' => $defaultCurrency->id,
            ])
            ->create();

        // Create draft sales transactions
        SalesTransaction::factory()
            ->count(10)
            ->draft()
            ->recycle($posCounters)
            ->state([
                'currency_id' => $defaultCurrency->id,
            ])
            ->create();

        // Create voided sales transactions
        SalesTransaction::factory()
            ->count(5)
            ->voided()
            ->recycle($posCounters)
            ->state([
                'currency_id' => $defaultCurrency->id,
            ])->create();
    }
}
