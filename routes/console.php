<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schema;


if (Schema::hasTable('settings') && !is_null(\App\Standards\Enums\ItemDelay::NORMAL->data()))
{
    \Illuminate\Support\Facades\Schedule::command('observer:check-items')
        ->cron(\App\Standards\Enums\ItemDelay::NORMAL->cronSignature())
        ->onSuccess(fn() => Artisan::output())
        ->onFailure(fn() => Artisan::output());
}
