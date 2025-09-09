<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
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

            'username' => 'nullable|string|max:255',
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'profile.avatar' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'profile.gender' => 'nullable|string|in:male,female,other',
            'profile.dob' => 'nullable|date|before_or_equal:today',
            'profile.phone' => 'nullable|string|max:20',
            'profile.country_id' => 'nullable|exists:countries,id',
            'profile.state_id' => 'nullable|exists:states,id',
            'profile.city_id' => 'nullable|exists:cities,id',
            'profile.zipcode' => 'nullable|string|max:20',
            'profile.street' => 'nullable|string|max:255',
        ];
    }
}
