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
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'exchange_rate' => 1.52],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'exchange_rate' => 1.35],
            ['code' => 'SGD', 'name' => 'Singapore Dollar', 'exchange_rate' => 1.33],
        ];

        // Check which currencies already exist
        $existingCurrencies = Currency::pluck('code')->toArray();

        // Filter out existing currencies
        $availableCurrencies = array_filter($currencies, function($currency) use ($existingCurrencies) {
            return !in_array($currency['code'], $existingCurrencies);
        });

        // If there are available currencies, use the first one
        if (!empty($availableCurrencies)) {
            $currency = reset($availableCurrencies);
            
            return [
                'id' => $this->faker->uuid(),
                'code' => $currency['code'],
                'name' => $currency['name'],
                'exchange_rate' => $currency['exchange_rate'],
            ];
        }

        // If no new currencies, generate a completely unique code
        do {
            $uniqueCode = strtoupper(substr(md5(uniqid()), 0, 3));
        } while (in_array($uniqueCode, $existingCurrencies));

        // Choose a random currency to base the new entry on
        $randomCurrency = $currencies[array_rand($currencies)];

        return [
            'id' => $this->faker->uuid(),
            'code' => $uniqueCode,
            'name' => $randomCurrency['name'],
            'exchange_rate' => $randomCurrency['exchange_rate'],
        ];
    }
}
