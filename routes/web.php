<?php

use App\Http\Controllers\NotificationController;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/test', function () {

    $user = User::find(1);

    $notificationController = new NotificationController();
    $notificationController->createNotification('dit is een test message', 'high', $user);


    return ['message' => 'check your mail box'];

});
