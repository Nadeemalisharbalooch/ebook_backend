<?php

namespace App\Http\Requests\User;

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
        'name'     => 'nullable|string|max:255',
        'email'    => 'nullable|email|max:255',
        'avatar'   => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        'gender'   => 'nullable|string|in:male,female,other',
        'dob'      => 'nullable|date|before_or_equal:today',
        'phone'    => 'nullable|string|max:20',
        'country'  => 'nullable|string|max:100',
        'state'    => 'nullable|string|max:100',
        'city'     => 'nullable|string|max:100',
        'zipcode'  => 'nullable|string|max:20',
        'address'  => 'nullable|string|max:255',
    ];
}
}
