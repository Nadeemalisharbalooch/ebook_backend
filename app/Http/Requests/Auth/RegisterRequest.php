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
            'name' => ['required', 'string', 'max:255'],
            'email' => [new UniqueEmailRule],
            'password' => ['required', 'confirmed', 'min:8'],
            'password_confirmation' => ['required', 'same:password'],
        ];
    }
}
