<?php

namespace App\Http\Requests;

class PasswordResetMailRequest extends BaseRequest
{

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
        ];
    }
}
