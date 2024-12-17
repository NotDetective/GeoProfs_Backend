<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordResetMailRequest;

class MailController extends Controller
{

    public function sendPasswordResetEmail(PasswordResetMailRequest $request)
    {
        // Send password reset email
    }

}
