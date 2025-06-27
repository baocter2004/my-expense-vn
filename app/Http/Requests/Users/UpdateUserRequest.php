<?php

namespace App\Http\Requests\Users;

use App\Consts\UserConst;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected $userId;

    public function __construct()
    {
        parent::__construct();
        $this->userId = Auth::id();
    }


    public function rules(): array
    {
        $id = Auth::id();
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
                Rule::unique('users', 'email')->ignore($this->userId),
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
        ];
    }
}
