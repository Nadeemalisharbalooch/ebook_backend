<?php

namespace App\Http\Requests\Auth;

use App\Rules\UniqueEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'role'=> ['required', 'string', 'max:255'],
            'email' => ['required', new UniqueEmailRule],
            'password' => ['required', 'confirmed', 'min:8'],
            'is_accept_terms' => ['required', 'boolean'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
}
