<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateLeaveRequest;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    #[OA\Post(path:'/leave/create', summary: 'Create a new leave request' , tags: ['Leave'])]
    #[OA\HeaderParameter(name: 'Authorization', description: 'Bearer token.', in: 'header', required: true, example: 'Bearer token')]
    #[OA\RequestBody( request: true, description: 'Leave request details.', content: [
        new OA\JsonContent(
            required: ['leave_type_id', 'leave_date'],
            properties: [
                new OA\Property(property: 'leave_type_id', type: 'integer', example: 1),
                new OA\Property(property: 'reason', type: 'string', example: 'I need a break'),
                new OA\Property(property: 'leave_date', type: 'string', format: 'timestamp', example: '2021-07-01 00:00:00'),
                new OA\Property(property: 'leave_return', type: 'string', format: 'timestamp', example: '2021-07-05  00:00:00'),
            ],
            type: 'object',
        ),
    ])]
    #[OA\Response(response: '201', description: 'Leave request created successfully.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'message', type: 'string', example: 'Leave request created successfully'),
        new OA\Property(property: 'leave', type: 'object', example: [
            'id' => 1,
            'user_id' => 1,
            'manager_id' => 2,
            'leave_type_id' => 1,
            'reason' => 'I need a break',
            'leave_date' => '2021-07-01 00:00:00',
            'leave_return' => '2021-07-05 00:00:00',
            'status' => 'in behandeling',
            'created_at' => '2021-07-01T12:00:00Z',
            'updated_at' => '2021-07-01T12:00:00Z',
        ])
    ]))]
    #[OA\Response(response: '422', description: 'Invalid data.', content: new OA\JsonContent(properties: [
        new OA\Property(property: 'errors', type: 'object', example: [
            'leave_type_id' => ['The leave type id field is required.'],
            'leave_date' => ['The leave date field is required.'],
        ]),
    ]))]
    #[OA\Response(response: '401', description: 'Unauthenticated.')]
    public function store(CreateLeaveRequest $request)
    {
        $manager_id = $request->user()
            ->department
            ->permissions
            ->roles
            ->first()
            ->users
            ->first()
            ->id;

        $leave = Leave::create([
            'user_id' => $request->user()->id,
            'manager_id' => $manager_id,
            'leave_type_id' => $request->leave_type_id,
            'reason' => $request->reason ?? '',
            'date_leave' => $request->date_leave,
            'date_return' => $request->date_return ?? null,
            'status' => 'pending',
        ]);

        //TODO: notification system implementation
        //send the notification to the manager

        return response([
            'message' => 'Leave request created successfully',
            'leave' => $leave,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        //
    }
}
