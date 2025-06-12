<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStaffUserRequest extends FormRequest
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
        $userId = $this->route('user');

        return [
            'username' => 'nullable|string|unique:users,username,'.$userId.',id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$userId.',id',
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_suspended' => 'sometimes|boolean',
            'role' => 'sometimes|string|exists:roles,name',

            'profile' => 'sometimes|array',
            'profile.avatar' => 'nullable|string',
            'profile.gender' => 'nullable|string|in:male,female,other',
            'profile.dob' => 'nullable|date',
            'profile.phone' => 'nullable|string|max:20',
            'profile.country' => 'nullable|string|max:100',
            'profile.state' => 'nullable|string|max:100',
            'profile.city' => 'nullable|string|max:100',
            'profile.zipcode' => 'nullable|string|max:20',
            'profile.address' => 'nullable|string|max:255',
        ];
    }
}
