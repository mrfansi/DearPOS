<?php

namespace App\Console\Commands;

use App\Models\Currency;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class CurrencySync extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'currency:sync';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync currencies from an external source';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $request = Http::get('https://v6.exchangerate-api.com/v6/d0ec58661f70ae803f62364d/latest/USD');

        foreach ($request['conversion_rates'] as $code => $rate) {
            Currency::where('code', $code)
                ->update([
                    'exchange_rate' => $rate,
                    'updated_at' => Carbon::createFromTimestamp($request['time_last_update_unix']),
                    'next_update_at' => Carbon::createFromTimestamp($request['time_next_update_unix']),
                ]);
        }
    }
}
