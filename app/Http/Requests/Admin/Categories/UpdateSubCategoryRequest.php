<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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
    public function rules()
    {
        $subCategory = $this->route('sub_category');
        $subCategoryId = is_object($subCategory) ? $subCategory->id : $subCategory;

        return [
           /*  'category_id' => 'required|exists:categories,id', */
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
        ];
    }
}
