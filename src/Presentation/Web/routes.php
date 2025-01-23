<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Presentation\Web\Dashboard\Controllers\ConvertCurrencyController;
use Presentation\Web\Dashboard\Controllers\ShowDashboardController;
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
    Route::get('/dashboard', ShowDashboardController::class)->name('dashboard');
    Route::post('/currency/convert', ConvertCurrencyController::class)->name('dashboard.convert-currency');

    Route::prefix('user')->group(function (): void {
        Route::get('/profile', ShowUserProfileController::class)
            ->name('profile.show');

        Route::delete('/other-browser-sessions', DeleteOtherBrowserSessionsController::class)
            ->name('other-browser-sessions.destroy');

        Route::delete('/', DeleteAccountController::class)
            ->name('current-user.destroy');
    });
});
