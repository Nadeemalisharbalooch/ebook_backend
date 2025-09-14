<?php

namespace App\Http\Requests\Vendor;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BookUpdateRequest extends FormRequest
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

        $book = $this->route('book'); // Model instance via slug binding

        return [
            'sub_category_id'  => ['nullable', 'exists:sub_categories,id'],

            // Book details
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['nullable', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],

            // Pricing
            'price'            => ['required', 'numeric', 'min:0'],
            'discount_price'   => ['nullable', 'numeric', 'lte:price'],

            // Media
            'cover_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'images'           => ['nullable', 'array'],
            'images.*'         => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],

            // Extra details
            'language'         => ['nullable', 'string', 'max:100'],



            'edition'          => ['nullable', 'string', 'max:100'],
            'pages'            => ['nullable', 'integer', 'min:1'],
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
