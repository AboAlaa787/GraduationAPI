<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => 'string|filled',
            'last_name' => 'string|filled',
            'national_id' => 'nullable|string|size:11',
            'client_id' => 'integer|exists:clients,id',
            'phone' => 'filled|string|size:10|unique:customers,phone,NULL,id,client_id,' . $this->input('client_id'),
            'devices_count' => 'integer|min:0',
        ];
    }
}
