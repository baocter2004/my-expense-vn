<?php

namespace App\Http\Requests\Users;

use App\Consts\GlobalConst;
use App\Consts\UserConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetUserRequest extends FormRequest
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
            'last_name'  => 'nullable|string',
            'first_name' => 'nullable|string',
            'email'      => 'nullable|string',
            'gender'     => [
                'nullable',
                Rule::in(array_keys(UserConst::GENDER))
            ],
            'is_active'  => [
                'nullable',
                Rule::in(array_keys(GlobalConst::STATUS))
            ],
            'from_date'  => 'nullable|date',
            'to_date'    => 'nullable|date',
        ];
    }
}
