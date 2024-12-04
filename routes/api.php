<?php

use App\Http\Controllers\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
//
//Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['api'] ], function () {
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
    // here need to go all API routes that do not require the user to be authenticated(logged in)

    Route::group(['middleware' => ['auth:sanctum']], function () {

        Route::post('/logout', [AuthenticatedSessionController::class, 'destroy']);

        // here need to go all API routes that require the user to be authenticated(logged in)

    });

});
