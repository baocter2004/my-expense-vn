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
            ]
        ];
    }
}
