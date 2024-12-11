<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class AuthenticatedSessionController extends Controller
{

    #[OA\Post(path: '/login', summary: 'Create a new session.', tags: ['Authentication'])]
    #[OA\RequestBody(description: 'User credentials.', required: true, content: [
        new OA\JsonContent(
            required: ['email', 'password'],
            properties: [
                new OA\Property(property: 'email', type: 'string', example: 'user@app.com'),
                new OA\Property(property: 'password', type: 'string', example: 'password'),
            ],
            type: 'object',
        ),
    ])]
    #[OA\Response(response: '201', description: 'Session created.', content: new OA\JsonContent(properties: [
            new OA\Property(property: 'token', type: 'string', example: 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VyX2lkIjoxLCJlbWFpbCI6InVzZXJAYXBwLmNvbSIsImV4cCI6MTYyNjQwNjYwNn0.')
        ]))]
    #[OA\Response(response: '422', description: 'Invalid credentials.')]
    public function store(LoginRequest $request): Response
    {
        $request->authenticate();


        $request->session()->regenerate();

        return response([
            'token' => 'Bearer ' . $request->session()->token(),
        ], 201);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response([
            'message' => 'Logged out',
        ], 200);
    }
}
