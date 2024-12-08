<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Clear existing currencies
        DB::table('currencies')->truncate();

        // Read currencies from JSON file
        $currenciesPath = database_path('json/currencies.json');
        $currenciesJson = File::get($currenciesPath);
        $currencies = json_decode($currenciesJson, true);

        // Seed currencies with default exchange rate
        foreach ($currencies as $code => $currency) {
            DB::table('currencies')->insert([
                'code' => $code,
                'name' => $currency['name'],
                'symbol' => $currency['symbol'] ?? null,
                'symbol_native' => $currency['symbol_native'] ?? null,
                'decimal_digits' => $currency['decimal_digits'] ?? 2,
                'rounding' => $currency['rounding'] ?? 0,
                'name_plural' => $currency['name_plural'] ?? null,
                'exchange_rate' => 1.0000, // Default exchange rate
                'next_update_at' => now()->addDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
