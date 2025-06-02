<?php

namespace App\Http\Requests\Admin\EmailTempalte;

use App\Rules\ImageRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Shaz3e\EmailBuilder\App\Models\EmailTemplate;

class StoreEmailTemplateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'header' => $this->has('header') ? 1 : 0,
            'footer' => $this->has('footer') ? 1 : 0,
        ]);
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
            'key' => [
                'required',
                'string',
                'max:255',
                Rule::unique(EmailTemplate::class)->ignore($this->email_template),
            ],
            'name' => ['required', 'string', 'max:255'],
            'subject' => ['required', 'string', 'min:3', 'max:255'],
            'body' => ['required', 'string'],
            'placeholders' => ['nullable', 'string'],
            'header' => ['required', 'in:0,1'],
            'footer' => ['required', 'in:0,1'],
        ];
    }
}
