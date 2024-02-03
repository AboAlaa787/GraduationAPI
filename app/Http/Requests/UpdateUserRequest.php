<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class UpdateUserRequest extends FormRequest
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
            'phone' => [
                'max:10',
                'min:10'
            ]
        ];
    }
    public function response(array $errors)
    {
        // Returning a JSON response with the error messages
        return response()->json(['errors' => $errors], 422);
    }
}
