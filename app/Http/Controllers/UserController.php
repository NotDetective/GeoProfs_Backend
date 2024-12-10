<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request
        $validatedData = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'workers_id' => ['required', 'string', 'unique:users,workers_id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'street' => ['required', 'string', 'max:255'],
            'street_number' => ['required', 'string', 'max:10'],
            'postal_code' => ['required', 'string', 'max:20'],
            'city' => ['required', 'string', 'max:255'],
            'contract_type' => ['required', 'string', 'max:50'],
            'work_hours' => ['required', 'numeric', 'min:0'],
            'hired_at' => ['required', 'date'],
            'role' => ['required', 'string', 'max:50'],
            'department' => ['required', 'string', 'max:100'],
            'section' => ['required', 'string', 'max:100'],
        ]);

          'department_id',
        'section_id',
        'employee_id',
        'first_name',
        'middle_name',
        'last_name',
        'street',
        'house_number',
        'zip_code',
        'city',
        'contract_type',
        'contract_hours',
        'hire_date',
        'email',
        'password',

        // Generate a random password
        $randomPassword = Str::random(12);

        // Create and save the user
        $user = User::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'middlename' => $validatedData['middlename'] ?? null,
            'workers_id' => $validatedData['workers_id'],
            'email' => $validatedData['email'],
            'password' => Hash::make($randomPassword), // Hash the password
            'street' => $validatedData['street'] ?? null,
            'street_number' => $validatedData['street_number'] ?? null,
            'postal_code' => $validatedData['postal_code'] ?? null,
            'city' => $validatedData['city'] ?? null,
            'contract_type' => $validatedData['contract_type'] ?? null,
            'work_hours' => $validatedData['work_hours'] ?? null,
            'hired_at' => $validatedData['hired_at'] ?? null,
            'role' => $validatedData['role'] ?? null,
            'department' => $validatedData['department'] ?? null,
            'section' => $validatedData['section'] ?? null,
        ]);

        // Return success response
        return response()->json([
            'message' => 'User created successfully! Password has been sent via email.',
            'user' => $user,
        ], 201);
    }
}
