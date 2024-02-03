<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use \App\Rules\AlphaNumeric;
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
            'username' => [
                'required',
<<<<<<< HEAD
                'max:50',
                'string',
                'email',
                'lowercase',
                'unique:users,email,NULL,id,center_id,' . $this->input('center_id')
=======
                'max:20',
                'min:5',
                new AlphaNumeric,
                'unique:users,username,NULL,id,center_id,' . $this->input('center_id')
>>>>>>> 9912189c778b1639e1d39681648a0f08d1430f3b
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
            'username.required' => 'The username field is required.',
            // custom error messages for other fields if needed
        ];
    }

    public function response(array $errors)
    {
        // Returning a JSON response with the error messages
        return response()->json(['errors' => $errors], 422);
    }
}
