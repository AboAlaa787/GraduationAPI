<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class CreateUserRequest extends FormRequest
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
            'email' => [
                'required',
                'unique:users',
                'max:50',
                'string',
                'email',
                'lowercase',
                'min:5',
            ],
            'name' => [
                'required',
                'max:20',
                'min:2',
                'alpha',
            ],
            'last_name' => [
                'required',
                'max:20',
                'min:2',
                'alpha',
            ],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults()
            ],
            'rule_id' => [
                'required',
                'numeric'
            ],
            'phone' => [
                'max:10',
                'min:10'
            ]
        ];
    }
}
