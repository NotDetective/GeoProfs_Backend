<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateAndCreateUserRequest;

class UserController extends Controller
{
    public function store(UpdateAndCreateUserRequest $request)
    {
        // Generate a random password
        $randomPassword = Str::random(12);

        // Create and save the user
        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'middle_name' => $request['middle_name'] ?? null,
            'employee_id' => $request['employee_id'],
            'email' => $request['email'],
            'password' => Hash::make($randomPassword), // Hash the password
            'street' => $request['street'],
            'house_number' => $request['house_number'],
            'zip_code' => $request['zip_code'],
            'city' => $request['city'],
            'contract_type' => $request['contract_type'],
            'contract_hours' => $request['contract_hours'],
            'hire_date' => $request['hired_date'],
            'role' => $request['role'],
            'department_id' => $request['department_id'],
            'section_id' => $request['section_id'],
        ]);

        // Return success response
        return response()->json([
            'message' => 'User created successfully! Password has been sent via email.',
            'user' => $user,
        ], 201);
    }
}
