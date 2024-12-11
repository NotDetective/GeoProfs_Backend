<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['api'] ], function () {

    Route::group(['middleware' => ['guest']], function () {

        Route::post('/login', [AuthenticatedSessionController::class, 'store'])
            ->name('login');
        // here need to go all API routes that do not require the user to be authenticated(logged in)


    });

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
            ->name('logout');
        // here need to go all API routes that require the user to be authenticated(logged in)


    });

});

//Route::post('/user/create', [UserController::class, 'store']);

