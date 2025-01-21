<?php

use Illuminate\Support\Facades\Route;
use Presentation\Web\Dashboard\Controllers\ShowDashboardController;
use Presentation\Web\User\Controllers\DeleteCurrentUserController;
use Presentation\Web\User\Controllers\DeleteOtherBrowserSessionsController;
use Presentation\Web\User\Controllers\DeleteProfilePhotoController;
use Presentation\Web\User\Controllers\ShowUserProfileController;
use Presentation\Web\Welcome\Controllers\ShowWelcomeController;

Route::get('/', ShowWelcomeController::class)
    ->name('welcome');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', ShowDashboardController::class)->name('dashboard');
});

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {
    $authMiddleware = config('jetstream.guard')
        ? 'auth:'.config('jetstream.guard')
        : 'auth';

    $authSessionMiddleware = config('jetstream.auth_session', false)
        ? config('jetstream.auth_session')
        : null;

    Route::group(['middleware' => array_values(array_filter([$authMiddleware, $authSessionMiddleware]))], function () {
        // User & Profile...
        Route::get('/user/profile', ShowUserProfileController::class)
            ->name('profile.show');

        Route::delete('/user/other-browser-sessions', DeleteOtherBrowserSessionsController::class)
            ->name('other-browser-sessions.destroy');

        Route::delete('/user/profile-photo', DeleteProfilePhotoController::class)
            ->name('current-user-photo.destroy');

        Route::delete('/user', DeleteCurrentUserController::class)
            ->name('current-user.destroy');
    });
});
