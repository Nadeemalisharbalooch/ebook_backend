<?php

namespace App\Http\Requests\Admin\EmailTempalte;

use App\Rules\ImageRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreGlobalEmailTemplateRequest extends FormRequest
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
            'header_image' => [
                'nullable',
                new ImageRule,
            ],
            'header_text' => ['nullable', 'string'],
            'header_text_color' => ['nullable', 'string'],
            'header_background_color' => ['nullable', 'string'],

            'footer_image' => [
                'nullable',
                new ImageRule,
            ],
            'footer_text' => ['nullable', 'string'],
            'footer_text_color' => ['nullable', 'string'],
            'footer_background_color' => ['nullable', 'string'],
            'footer_bottom_image' => [
                'nullable',
                new ImageRule,
            ],
        ];
    }
}
