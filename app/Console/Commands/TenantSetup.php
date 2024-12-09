<?php

namespace App\Console\Commands;

use App\Helpers\Generator;
use App\Models\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use function Laravel\Prompts\search;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class TenantSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new tenant';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $name = text(
            label: 'Type your brand name',
            placeholder: 'ex. Dear POS',
            default: 'My Brand Name',
            required: true,
            validate: fn(string $value) => strlen($value) < 3 ? 'The brand name must be at least 3 characters.' : null,
            hint: 'This will be displayed as your brand name'
        );

        $timezone = select(
            label: 'Select your timezone',
            options: Generator::getTimezoneList(),
            default: 'Asia/Jakarta',
            scroll: 10,
            hint: 'Select your preferred timezone',
        );

        $currency = select(
            label: 'Select your currency',
            options: Generator::getCurrencyList(),
            default: 'IDR',
            scroll: 10,
            hint: 'Choose your preferred currency'
        );

        $language = select(
            label: 'Select your language',
            options: Generator::getLanguageList(),
            default: 'en',
            scroll: 10,
            hint: 'Choose your preferred language'
        );

        $tenant = Tenant::create([
            'code' => Generator::uniqueNumber(),
            'name' => $name,
            'timezone' => $timezone,
            'currency' => $currency,
            'language' => $language,
        ]);

        $tenant->domains()->create([
            'domain' => str()->slug($name),
        ]);

    }
}
