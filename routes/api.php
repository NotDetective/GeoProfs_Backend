<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::patch('/session/update', [AuthenticatedSessionController::class, 'update'])
    ->middleware(['auth:sanctum'])
    ->name('session.update');
