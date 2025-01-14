<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::group(['middleware' => ['api']], function () {

    Route::group(['middleware' => ['guest']], function () {

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->name('login');
        // here need to go all API routes that do not require the user to be authenticated(logged in)

        Route::post('/reset-password', [AuthenticatedSessionController::class, 'resetPassword'])
            ->name('password.reset');

        Route::group(['prefix' => 'mail'], function () {
            Route::post('/password-reset', [MailController::class, 'sendPasswordResetEmail'])
                ->name('password-reset-email');
        });
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');

        Route::patch('auth/check', [AuthenticatedSessionController::class, 'check'])
            ->name('auth.check');
        // here need to go all API routes that require the user to be authenticated(logged in)
        Route::post('user/create', [UserController::class, 'store']);

    });

});