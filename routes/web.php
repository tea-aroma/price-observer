<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group([ 'prefix' => 'recipient', 'as' => 'recipient.' ], function (Router $router)
{
    $router->get('/subscribe', [ \App\Http\Controllers\RecipientController::class, 'index' ])->name('subscribe');

    $router->post('/subscribe', [ \App\Http\Controllers\RecipientController::class, 'subscribe' ])->name('subscribe');

    $router->get('/confirm/{token?}', [ \App\Http\Controllers\RecipientController::class, 'confirm' ])->name('confirm');
});
