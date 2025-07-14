<?php

namespace App\Http\Requests\Categories;

use App\Consts\GlobalConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostCategoryRequest extends FormRequest
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
            'descriptions' => ['required', 'string'],
            'is_active' => [
                'nullable',
                'integer',
                Rule::in(array_keys(GlobalConst::STATUS)),
            ],
            'group_id' => ['nullable', 'integer', 'exists:groups,id'],
        ];
    }

    public function attributes() {
        return [
            'name' => 'Tên danh mục',
            'descriptions' => 'Mô tả danh mục',
            'is_active' => 'Hoạt động'
        ];
    }
}
