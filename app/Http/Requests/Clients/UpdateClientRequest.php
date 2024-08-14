<?php

namespace App\Http\Requests\Clients;

use App\Rules\UniqueEmailAcrossTables;
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
            'center_name' => 'string|filled',
            'phone' => 'nullable|string',
            'devices_count' => 'nullable|integer',
            'email' => ['string','filled',new UniqueEmailAcrossTables],
            'name' => 'string',
            'last_name' => 'string',
            'rule_id' => 'integer|nullable|exists:rules,id|filled',
            'email_verified_at' => 'nullable|date',
            'address' => 'string|filled',
            'national_id' => 'filled|string|size:11|unique:clients,national_id',
        ];
    }
}
