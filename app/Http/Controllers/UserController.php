<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateAndCreateUserRequest;

class UserController extends Controller
{
    public function store(UpdateAndCreateUserRequest $request)
    {
        // Sends employee's first and last name to generateEmployeeId function
        $employeeId = $this->generateEmployeeId($request['first_name'], $request['last_name']);

        // Generate a random password
        $randomPassword = Str::random(12);

        // Create and save the user
        $user = User::create([
            'first_name' => $request['first_name'],
            'last_name' => $request['last_name'],
            'middle_name' => $request['middle_name'] ?? null,
            'employee_id' => $employeeId,
            'email' => $request['email'],
            'password' => Hash::make($randomPassword), // Hash the password
            'street' => $request['street'],
            'house_number' => $request['house_number'],
            'zip_code' => $request['zip_code'],
            'city' => $request['city'],
            'contract_type' => $request['contract_type'],
            'contract_hours' => $request['contract_hours'],
            'hire_date' => $request['hired_date'],
            'role_id' => $request['role'],
            'department_id' => $request['department_id'],
            'section_id' => $request['section_id'],
        ]);

        // Return success response
        return response()->json([
            'message' => 'User created successfully! Password has been sent via email.',
            'user' => $user,
        ], 201);
    }

    private function generateEmployeeId(string $firstname, string $lastname)
    {
        $firstname = strtoupper(substr($firstname, 0, 2));
        $lastname = strtoupper(substr($lastname, 0, 2));

        $employeeId = $firstname . $lastname;

        $count = User::where('employee_id', 'like', $employeeId . '%')->count();

        //Adds a 0 to the left of $count, unless $count is already 2 digits
        $count = str_pad($count + 1, 2, '0', STR_PAD_LEFT);

        $employeeId .= $count;

        return $employeeId;

    }
}
