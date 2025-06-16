<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateStaffUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        /** @var \App\Models\Role|null $role */

        $staffId = $this->route('staff');

        return [
            'username' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('users', 'username')->ignore($staffId),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($staffId),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'is_admin' => 'sometimes|boolean',
            'is_active' => 'sometimes|boolean',
            'is_suspended' => 'sometimes|boolean',
            'roles' => 'sometimes|array',
            'roles.*' => 'required|string|exists:roles,name',

            'profile' => 'sometimes|array',
            'profile.avatar' => 'nullable|string',
            'profile.gender' => 'nullable|string|in:male,female,other',
            'profile.dob' => 'nullable|date|before_or_equal:today',
            'profile.phone' => 'nullable|string|max:20',
            'profile.country' => 'nullable|string|max:100',
            'profile.state' => 'nullable|string|max:100',
            'profile.city' => 'nullable|string|max:100',
            'profile.zipcode' => 'nullable|string|max:20',
            'profile.address' => 'nullable|string|max:255',
        ];
    }
}
