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
        static $usedCurrencies = [];

        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'exchange_rate' => 1],
            ['code' => 'EUR', 'name' => 'Euro', 'exchange_rate' => 0.93],
            ['code' => 'GBP', 'name' => 'British Pound', 'exchange_rate' => 0.79],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'exchange_rate' => 149.50],
            ['code' => 'IDR', 'name' => 'Indonesian Rupiah', 'exchange_rate' => 15500],
        ];

        // Filter out already used currencies
        $availableCurrencies = array_filter($currencies, function($currency) use (&$usedCurrencies) {
            return !in_array($currency['code'], $usedCurrencies);
        });

        // If all currencies have been used, reset the used list
        if (empty($availableCurrencies)) {
            $usedCurrencies = [];
            $availableCurrencies = $currencies;
        }

        // Select a random currency
        $currency = fake()->randomElement($availableCurrencies);
        
        // Mark this currency as used
        $usedCurrencies[] = $currency['code'];

        return $currency;
    }
}
