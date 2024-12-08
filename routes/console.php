<?php

use App\Console\Commands\CurrencySync;
use Illuminate\Support\Facades\Schedule;

Schedule::command(CurrencySync::class)->daily();
