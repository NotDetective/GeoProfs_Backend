<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordResetMailRequest;
use Illuminate\Http\Response;

use Illuminate\Support\Facades\Password;

class MailController extends Controller
{

    public function sendPasswordResetEmail(PasswordResetMailRequest $request) : Response
    {
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response(['message' => __($status)], 200)
            : response(['message' => __($status)], 400);
    }
}
