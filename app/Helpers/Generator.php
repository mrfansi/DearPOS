<?php

namespace App\Helpers;

class Generator
{
    /**
     * Generate an 8-digit unique number
     */
    public static function uniqueNumber(): string
    {
        // Get current timestamp (microseconds)
        $timestamp = microtime(true);

        // Extract the decimal part and convert to integer
        $decimal = (int) (($timestamp - floor($timestamp)) * 1000000);

        // Generate a random number between 10-99
        $random = mt_rand(10, 99);

        // Combine and format to ensure 8 digits
        $number = "$decimal$random";

        // Take only the last 10 digits
        return substr($number, -10);
    }

    /**
     * Generate a unique string with prefix
     *
     * @param  string  $prefix  The prefix to use (e.g., 'INV', 'PO', 'DO')
     * @param  string  $separator  The separator between prefix and number (default: '-')
     * @param  int  $digits  The number of digits to generate (default: 8)
     */
    public static function uniquePrefix(string $prefix, string $separator = '-', int $digits = 8): string
    {
        // Convert prefix to uppercase
        $prefix = strtoupper($prefix);

        // Get current timestamp (microseconds)
        $timestamp = microtime(true);

        // Extract the decimal part and convert to integer
        $decimal = (int) (($timestamp - floor($timestamp)) * 1000000);

        // Generate a random number
        $random = mt_rand(10, 99);

        // Combine and format
        $number = "$decimal$random";

        // Take only the specified number of digits
        $number = substr($number, -$digits);

        // Combine prefix with number
        return "$prefix$separator$number";
    }

    /**
     * Get a list of all available timezones
     */
    public static function getTimezoneList(): array
    {
        return \DateTimeZone::listIdentifiers();
    }

    /**
     * Get a list of all available currencies
     *
     * @return array An associative array of currency codes and names
     */
    public static function getCurrencyList(): array
    {
        $currencies = json_decode(file_get_contents(database_path('json/currencies.json')), true);
        $currencyList = [];

        foreach ($currencies as $code => $currency) {
            $currencyList[$code] = $currency['name'];
        }

        return $currencyList;
    }

    /**
     * Get a list of all available languages
     *
     * @return array An associative array of language codes and names
     */
    public static function getLanguageList(): array
    {
        $languages = [
            'en' => 'English',
            'es' => 'Spanish',
            'fr' => 'French',
            'de' => 'German',
            'it' => 'Italian',
            'pt' => 'Portuguese',
            'ru' => 'Russian',
            'zh' => 'Chinese',
            'ja' => 'Japanese',
            'ko' => 'Korean',
        ];

        return $languages;
    }


}
