<?php

namespace App\Http\Requests\Users;

use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use App\Rules\UniqueEmailAcrossTables;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\ValidationRule;

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
            'email' => ['filled','email','string',new UniqueEmailAcrossTables],
            'name' => [
                'max:20',
                'min:2',
                'alpha',
                'filled',
            ],
            'last_name' => [
                'max:20',
                'min:2',
                'filled',
                'alpha',
            ],
            'password' => [
                'confirmed',
                Rules\Password::defaults(),
                'filled',
            ],
            'rule_id' => [
                'integer',
                'filled',
                'exists:rules,id'
            ],
            'phone' => [
                'max:10',
                'filled',
                'min:10'
            ]
        ];
    }
    public function response(array $errors): JsonResponse
    {
        // Returning a JSON response with the error messages
        return response()->json(['errors' => $errors], 422);
    }
}
