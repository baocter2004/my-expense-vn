<?php

namespace App\Http\Requests\Users;

use App\Consts\UserConst;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserByAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::guard('admin')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->segment(3);
        return [
            'first_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u',
            ],
            'last_name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[\pL\s]+$/u',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
            'birth_date' => [
                'nullable',
                'date',
                'before_or_equal:' . now()->subYears(13)->format('Y-m-d'),
            ],
            'gender' => [
                'nullable',
                'integer',
                Rule::in(array_keys(UserConst::GENDER))
            ],
            'reason_for_unactive' => [
                'sometimes'
            ],
            'avatar' => [
                'image',
                'mimes:jpeg,png,jpg,gif,svg',
                'max:4096'
            ]
        ];
    }
}
