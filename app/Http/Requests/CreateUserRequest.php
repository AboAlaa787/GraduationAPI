<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => [
                'required',
                'max:30',
                'string',
                'email',
                'unique:users,email,NULL,id,center_id,' . $this->input('center_id')
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
            'center_id' => [
                'required',
                'numeric'
            ],
            'phone' => [
                'max:10',
                'min:10'
            ]
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'The email field is required.',
            // custom error messages for other fields if needed
        ];
    }

    public function response(array $errors)
    {
        // Returning a JSON response with the error messages
        return response()->json(['errors' => $errors], 422);
    }
}
