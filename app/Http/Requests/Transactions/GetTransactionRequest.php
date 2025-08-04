<?php

namespace App\Http\Requests\Transactions;

use App\Consts\GlobalConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetTransactionRequest extends FormRequest
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
            'created_from' => 'nullable|date',
            'created_to' => 'nullable|date',
            'sort' => [
                'nullable',
                Rule::in(array_keys(GlobalConst::SORT_OPTIONS))
            ],
            'keyword' => 'nullable|string|max:255',
        ];
    }
}
