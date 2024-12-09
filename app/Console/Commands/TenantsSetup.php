<?php

namespace App\Console\Commands;

use App\Helpers\Generator;
use App\Models\Tenant;
use Illuminate\Console\Command;

use function Laravel\Prompts\confirm;
use function Laravel\Prompts\select;
use function Laravel\Prompts\text;

class TenantsSetup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenants:setup';

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

        $isCustomDomain = confirm(
            label: 'Do you want to use a custom domain?',
            default: false,
            yes: 'Yes',
            no: 'No',
            hint: 'If you want to use a custom domain, you can enter it here'
        );

        $domain = str()->slug($name);

        if ($isCustomDomain) {
            $domain = text(
                label: 'Type your custom domain',
                placeholder: 'ex. mydomain.com',
                validate: fn(string $value) => strlen($value) < 3 ? 'The domain name must be at least 3 characters.' : null,
                required: true,
                hint: 'This will be displayed as your custom domain',
            );
        }

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
            'domain' => $domain,
            'is_primary' => $tenant->domains()->count() === 0,
            'is_custom_domain' => $isCustomDomain
        ]);

    }
}
