<?php

namespace App\Http\Requests\Wallets;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostWalletRequest extends FormRequest
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
            'name'         => ['required', 'string', 'max:255'],
            'balance'      => ['nullable', 'numeric', 'min:0', 'regex:/^\d+(\.\d{1,2})?$/'],
            'currency'     => ['required', Rule::in(array_keys(\App\Consts\GlobalConst::CURRENCIES))],
            'is_default'   => ['sometimes', 'boolean'],
            'note'         => ['nullable', 'string'],
        ];
    }

    public function attributes()
    {
        return [
            'name'       => 'Tên ví',
            'balance'    => 'Số dư ban đầu',
            'currency'   => 'Loại tiền',
            'is_default' => 'Ví mặc định',
            'note'       => 'Ghi chú',
        ];
    }
}
