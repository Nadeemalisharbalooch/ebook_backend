<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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

            'sub_category_id'  => ['required', 'exists:sub_categories,id'],

            // Book details
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],

            // Pricing
            'price'            => ['required', 'numeric', 'min:0'],
            'discount_price'   => ['nullable', 'numeric', 'lte:price'],

            // Media
            'cover_image'      => ['nullable', 'max:255'],
            'images'           => ['nullable', 'array'],
            'images.*'         => ['max:255'],

            // Extra details
            'language'         => ['nullable', 'string', 'max:100'],
            'isbn'             => ['required', 'string', 'max:50', 'unique:books,isbn,'],

            'edition'          => ['nullable', 'string', 'max:100'],
            'pages'            => ['required', 'integer', 'min:1'],
            'dimensions'       => ['nullable', 'string', 'max:100'],

            // Enum fields
            'type'             => ['required', 'in:hard,soft,audio,video'],
            'status'           => ['required', 'in:draft,published'],

            // Stock
            'stock_quantity'   => ['required', 'integer', 'min:0'],
            'is_active'        => ['boolean'],
        ];
    }
}
