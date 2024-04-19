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
            'name' => 'string|filled|alpha',
            'last_name' => 'string|filled|alpha',
            'national_id' => 'string|size:11|unique:customers,national_id,NULL,id,client_id,' . $this->input('client_id'),
            'client_id' => 'integer|exists:clients,id',
            'phone' => 'string|size:10|filled',
            'email' => 'email|filled',
            'devices_count' => 'integer|min:0',
        ];
    }
}
