<?php

namespace Database\Factories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Currency>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Predefined list of currencies
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'exchange_rate' => 1],
            ['code' => 'EUR', 'name' => 'Euro', 'exchange_rate' => 0.93],
            ['code' => 'GBP', 'name' => 'British Pound', 'exchange_rate' => 0.79],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'exchange_rate' => 149.50],
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'exchange_rate' => 15500],
        ];

        // If no currencies exist, return the first currency
        if (Currency::count() === 0) {
            return $currencies[0];
        }

        // Find a currency that doesn't exist in the database
        foreach ($currencies as $currency) {
            $existingCurrency = Currency::where('code', $currency['code'])->first();
            if (!$existingCurrency) {
                return $currency;
            }
        }

        // If all currencies exist, throw an exception
        throw new \Exception('All predefined currencies already exist in the database.');
    }
}
