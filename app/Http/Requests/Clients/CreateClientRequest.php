<?php

namespace App\Http\Requests\Clients;

use App\Rules\UniqueEmailAcrossTables;
use Illuminate\Foundation\Http\FormRequest;

class CreateClientRequest extends FormRequest
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
            'center_name' => 'required|string',
            'phone' => 'nullable|string|max:10',
            'devices_count' => 'nullable|integer',
            'email' => ['required','email','string',new UniqueEmailAcrossTables],
            'name' => 'required|string|alpha',
            'last_name' => 'required|string|alpha',
            'rule_id' => 'nullable|exists:rules,id',
            'email_verified_at' => 'nullable|date',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'address' => 'required|string',
            'national_id' => 'required|string|size:11|unique:clients,national_id',
        ];
    }
}
