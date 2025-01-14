<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Requests\UpdateAndCreateUserRequest;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    #[OA\Post(path: '/user/create', summary: 'Creates new employee', tags: ['User'])]
    #[OA\HeaderParameter(name: 'Authorization', description: 'Bearer token.', in: 'header', required: true, example: 'Bearer token')]
    #[OA\RequestBody(description: 'User credentials.', required: true, content: [
        new OA\JsonContent(
            required: [
                'first_name',
                'last_name',
                'email',
                'street',
                'house_number',
                'zip_code',
                'city',
                'contract_type',
                'contract_hours',
                'hire_date',
                'role_id',
                'department_id',
                'section_id'
            ],
            properties: [
                new OA\Property(property: 'first_name', type: 'string', example: 'John'),
                new OA\Property(property: 'last_name', type: 'string', example: 'Doe'),
                new OA\Property(property: 'middle_name', type: 'string', example: 'Johannes'),
                new OA\Property(property: 'email', type: 'string', example: 'user@app.com'),
                new OA\Property(property: 'street', type: 'string', example: 'Kerkweg'),
                new OA\Property(property: 'house_number', type: 'string', example: '17'),
                new OA\Property(property: 'zip_code', type: 'string', example: '1234AB'),
                new OA\Property(property: 'city', type: 'string', example: 'Malden'),
                new OA\Property(property: 'contract_type', type: 'string', example: 'Fulltime'),
                new OA\Property(property: 'contract_hours', type: 'integer', example: '1'),
                new OA\Property(property: 'hire_date', type: 'date', example: 'YYYY-MM-DD'),
                new OA\Property(property: 'role_id', type: 'integer', example: '1'),
                new OA\Property(property: 'department_id', type: 'integer', example: '1'),
                new OA\Property(property: 'section_id', type: 'integer', example: '1'),
            ],
            type: 'object',
        ),
    ])]
    #[OA\Response(response: '201', description: 'User created successfully.')]
    #[OA\Response(response: '401', description: 'Unauthenticated.')]
    #[OA\Response(response: '422', description: 'Invalid form data.')]
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
            'hire_date' => $request['hire_date'],
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
