<?php

namespace App\Http\Requests\Transactions;

use App\Consts\TransactionConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
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
            'user_id' => [
                'nullable',
                'integer',
                Rule::exists('users', 'id')
            ],

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
            ],

            'wallet_id' => [
                'required',
                'integer',
                Rule::exists('wallets', 'id')
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1'
            ],

            'receipt_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],

            'status' => [
                'nullable',
                'integer',
                Rule::in(array_keys(TransactionConst::STATUS_LABELS))
            ],

            'transaction_type' => [
                'required',
                'string',
                Rule::in(array_keys(TransactionConst::TRANSACTION_TYPE))
            ],

            'occurred_at' => [
                'required',
                'date'
            ],

            'description' => [
                'nullable',
                'string',
                'max:500'
            ],

            'currency'     => [
                'required',
                'integer',
                Rule::in(array_keys(\App\Consts\GlobalConst::CURRENCIES))
            ],
        ];
    }

    public function attributes()
    {
        return [
            'user_id' => 'Người dùng',
            'category_id' => 'Danh mục',
            'wallet_id' => 'Ví',
            'code' => 'Mã giao dịch',
            'amount' => 'Số tiền',
            'status' => 'Trạng thái',
            'transaction_type' => 'Loại giao dịch',
            'occurred_at' => 'Ngày phát sinh',
            'description' => 'Mô tả',
            'receipt_image' => 'Ảnh biên lai',
            'parent_transaction_id' => 'Giao dịch gốc',
            'is_reversal' => 'Đảo chiều',
            'currency' => 'Loại tiền'
        ];
    }
}
