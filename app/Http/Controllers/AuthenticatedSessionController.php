<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use OpenApi\Attributes as OA;

#[OA\SecurityScheme(securityScheme: 'bearerAuth', type: 'http', scheme: 'bearer')]
class AuthenticatedSessionController extends Controller
{
    #[OA\Post(path: '/login', summary: 'Create a new session.', tags: ['Authentication'])]
    #[OA\RequestBody(description: 'User credentials.', required: true, content: [
        new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@app.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
                new OA\Property(property: 'remember', type: 'boolean', example: true),
            ],
            type: 'object',
        ),
    ])]
    #[OA\Response(response: '201', description: 'Session created.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'token', type: 'string', example: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJlbWFpbCI6InVzZXJAYXBwLmNvbSIsImV4cCI6MTYyNjQwNjYwNn0.'),
    ]))]
    #[OA\Response(response: '422', description: 'Invalid credentials.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'errors', type: 'object', example: [
            'email' => ['We hebben een email adres nodig anders kunnen we je niet inloggen.'],
            'password' => ['We hebben een wachtwoord nodig anders kunnen we je niet inloggen.'],
            'remember' => ['remember must be a boolean.'],
        ]),
    ]))]
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();

        $request->session()->regenerate();

        return response([
            'token' => 'Bearer ' . $request->session()->token(),
        ], 201);
    }

    #[OA\Post(path: '/logout', summary: 'Destroy the current session.', tags: ['Authentication'])]
    #[OA\HeaderParameter(name: 'Authorization', description: 'Bearer token.', in: 'header', required: true, example: 'Bearer token')]
    #[OA\Response(response: '200', description: 'Session destroyed.')]
    #[OA\Response(response: '401', description: 'Unauthenticated.')]
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response([
            'message' => 'Logged out',
        ], 200);
    }

    #[OA\Patch(path: '/auth/check', summary: 'Checks if the API token is valid.', tags: ['Authentication'])]
    #[OA\HeaderParameter(name: 'Authorization', description: 'Bearer token.', in: 'header', required: true, example: 'Bearer token')]
    #[OA\Response(response: '200', description: 'API token is valid.')]
    #[OA\Response(response: '401', description: 'Unauthenticated.')]
    public function check(): Response
    {
        return response([
            'message' => 'API token is valid',
        ], 200);
    }

    #[OA\Post(path: '/reset-password', summary: 'Reset the user’s password.', tags: ['Authentication'])]
    #[OA\RequestBody(description: 'User credentials.', required: true, content: [
        new OA\JsonContent(
            required: ['email', 'password', 'password_confirmation', 'token'],
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@app.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
                new OA\Property(property: 'password_confirmation', type: 'string', example: 'password'),
                new OA\Property(property: 'token', description: 'The token is sent to the user’s email address.', type: 'string', example: 'token'),
            ],
            type: 'object',
        ),
    ])]
    #[OA\Response(response: '200', description: 'Password reset.')]
    #[OA\Response(response: '400', description: 'Invalid token.')]
    #[OA\Response(response: '422', description: 'Invalid credentials.')]
    public function resetPassword(ResetPasswordRequest $request): Response
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            },
        );

        return $status === Password::PASSWORD_RESET
            ? response(['message' => __($status)], 200)
            : response(['message' => __($status)], 400);
    }
}
