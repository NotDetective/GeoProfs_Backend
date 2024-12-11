<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAndCreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'employee_id' => ['required', 'string', 'unique:users,employee_id'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'street' => ['required', 'string', 'max:50'],
            'house_number' => ['required', 'string', 'max:10'],
            'zip_code' => ['required', 'string', 'max:10'],
            'city' => ['required', 'string', 'max:50'],
            'contract_type' => ['required', 'string', 'max:50'],
            'contract_hours' => ['required', 'numeric'],
            'hire_date' => ['required', 'date'],
            'role_id' => ['required', 'exist:roles,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'section_id' => ['required', 'exists:sections,id'],
        ];
    }
}
