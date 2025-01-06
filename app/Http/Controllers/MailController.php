<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PasswordResetMailRequest;
use Illuminate\Http\Response;
use OpenApi\Attributes as OA;

use Illuminate\Support\Facades\Password;

class MailController extends Controller
{

    #[OA\Post(path: 'mail/password-reset', summary: 'Send a password reset email.', tags: ['Mail'])]
    #[OA\RequestBody(description: 'User email.', required: true, content: [
        new OA\JsonContent(
            required: ['email'],
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@app.com'),
            ],
        ),
    ])]
    #[OA\Response(response: '200', description: 'Password reset email sent.')]
    #[OA\Response(response: '400', description: 'Password reset email not sent.')]
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
