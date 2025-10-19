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
        'category_id'      => ['required', 'exists:categories,id'],
        'sub_category_id'  => ['required', 'exists:sub_categories,id'],

        // Book details
        'title'            => ['required', 'string', 'max:255'],
        'author'           => ['required', 'string', 'max:255'],
        'description'      => ['nullable', 'string'],

        // Pricing
        'price'            => ['required', 'numeric', 'min:0'],
        'discount_price'   => ['nullable', 'numeric', 'lte:price'],
        'currency'         => ['nullable', 'string', 'max:10'], // default handled in DB

        // Media
        'cover_image'      => ['required', 'string', 'max:255'],
        'images'           => ['nullable', 'array'],
        'images.*'         => ['nullable', 'string', 'max:255'],

        // Extra details
        'language'         => ['nullable', 'string', 'max:100'],
        'isbn'             => ['required', 'string', 'max:50', 'unique:books,isbn,' . $this->book],
        'edition'          => ['nullable', 'string', 'max:100'],
        'pages'            => ['nullable', 'integer', 'min:1'],
        'dimensions'       => ['nullable', 'string', 'max:100'],

        // Enums (Updated)
        'format'           => ['required', 'in:Digital,Physical'],
        'type'             => ['required', 'in:Ebook,Hardcover,Paperback,Audiobook'],
        'status'           => ['required', 'in:Draft,Published,Unpublished'],

        // Additional fields
        'tags'             => ['nullable', 'array'],
        'tags.*'           => ['string', 'max:50'],
        'published_at'     => ['required', 'date'],
        'is_featured'      => ['boolean'],

        // Stock
        'stock_quantity'   => ['required', 'integer', 'min:0'],
        'is_active'        => ['boolean'],
    ];
}

}
