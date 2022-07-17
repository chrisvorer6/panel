<?php

use App\Http\Controllers\Client\IndexController;
use App\Http\Controllers\Client\Servers\PowerController;
use App\Http\Controllers\Client\Servers\ServerController;
use App\Http\Controllers\Client\Servers\StatusController;
use App\Http\Middleware\AuthenticateServerAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\Servers\SettingsController;

Route::get('/dashboard', [IndexController::class, 'index'])->name('dashboard');

Route::group(['prefix' => '/servers/{server}', 'middleware' => AuthenticateServerAccess::class, 'as' => 'servers.'], function () {
    Route::get('/', [ServerController::class, 'show'])->name('show');

    Route::group(['as' => 'show.'], function () {
        Route::get('/status', [StatusController::class, 'show'])->name('status');
        Route::post('/status', [PowerController::class, 'sendCommand'])->name('status.update');

        Route::group(['prefix' => '/settings', 'as' => 'settings.'], function () {
            Route::get('/', [SettingsController::class, 'index'])->name('index');
        });
    });
});