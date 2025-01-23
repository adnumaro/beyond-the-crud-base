<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Presentation\Web\ExchangeConverter\Controllers\ConvertExchangeConverterController;
use Presentation\Web\ExchangeConverter\Controllers\ShowExchangeConverterController;
use Presentation\Web\User\Controllers\DeleteAccountController;
use Presentation\Web\User\Controllers\DeleteOtherBrowserSessionsController;
use Presentation\Web\User\Controllers\ShowUserProfileController;
use Presentation\Web\Welcome\Controllers\ShowWelcomeController;

Route::get('/', ShowWelcomeController::class)
    ->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function (): void {
    Route::get('/exchange-converter', ShowExchangeConverterController::class)->name('exchange-converter');
    Route::post('/exchange-converter/convert', ConvertExchangeConverterController::class)->name('exchange-converter.convert');

    Route::prefix('user')->group(function (): void {
        Route::get('/profile', ShowUserProfileController::class)
            ->name('profile.show');

        Route::delete('/other-browser-sessions', DeleteOtherBrowserSessionsController::class)
            ->name('other-browser-sessions.destroy');

        Route::delete('/', DeleteAccountController::class)
            ->name('current-user.destroy');
    });
});
