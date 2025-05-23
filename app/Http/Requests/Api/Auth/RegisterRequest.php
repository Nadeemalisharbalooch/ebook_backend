<?php

namespace App\Http\Requests\Api\Auth;

use App\Http\Requests\BaseFormRequest;
use App\Rules\ValidEmail;

class RegisterRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', 'unique:users,email', new ValidEmail],
            'password' => 'required|string|min:8|confirmed',
        ];
    }
}
