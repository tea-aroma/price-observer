<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [ \App\Http\Controllers\SubscribeController::class, 'index' ])->name('subscribe.index');

Route::post('/subscribe', [ \App\Http\Controllers\SubscribeController::class, 'subscribe' ])->name('subscribe.subscribe');
