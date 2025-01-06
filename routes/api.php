<?php

use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\MailController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api']], function () {

    Route::group(['middleware' => ['guest']], function () {

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->name('login');
        // here need to go all API routes that do not require the user to be authenticated(logged in)

        Route::group(['prefix' => 'mail'], function () {
            Route::post('/password-reset', [MailController::class, 'sendPasswordResetEmail'])
                ->name('password-reset-email');
        });
    });

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
        // here need to go all API routes that require the user to be authenticated(logged in)

    });

});

