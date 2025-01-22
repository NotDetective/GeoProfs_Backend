<?php

namespace App\Http\Requests;

use App\LeaveStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeaveRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'leave_request_id' => ['array', 'required'],
            'leave_request_status' => ['array', 'required', Rule::in('approved', 'rejected')],
        ];
    }
}
