<?php

namespace App\Http\Requests\Clients;

use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
            'center_name' => 'string',
            'phone' => 'nullable|string',
            'devices_count' => 'nullable|integer',
            'email' => 'string|unique:clients',
            'name' => 'string',
            'last_name' => 'string',
            'rule_id' => 'nullable|exists:rules,id',
            'email_verified_at' => 'nullable|date',
            'password' => 'string',
            'address' => 'string',
        ];
    }
}
