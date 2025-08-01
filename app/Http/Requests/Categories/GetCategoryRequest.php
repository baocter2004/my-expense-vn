<?php

namespace App\Http\Requests\Categories;

use App\Consts\GlobalConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetCategoryRequest extends FormRequest
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
            'name' => 'nullable|string|max:255',
            'descriptions' => 'nullable|string',
            'is_active' => [
                'integer',
                'nullable',
                Rule::in(GlobalConst::STATUS)
            ],
            'keyword' => 'nullable|string|max:255',
            'created_from' => 'nullable|date',
            'created_to' => 'nullable|date',
            'sort' => [
                'nullable',
                Rule::in(array_keys(GlobalConst::SORT_OPTIONS))
            ]
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên danh mục',
            'descriptions' => 'Mô tả',
            'is_active' => 'Trạng thái',
            'keyword' => 'Từ khóa tìm kiếm',
            'created_from' => 'Ngày bắt đầu',
            'created_to' => 'Ngày kết thúc',
            'sort' => 'Sắp xếp',
        ];
    }
}
