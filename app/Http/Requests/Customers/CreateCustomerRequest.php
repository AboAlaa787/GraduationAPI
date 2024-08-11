<?php

namespace App\Http\Requests\Customers;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
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
            'name' => 'required|string|max:20|min:2',
            'last_name' => 'required|string|max:20|min:2',
            'national_id' => 'nullable|string|size:11',
            'client_id' => 'integer|required|exists:clients,id',
            'phone' => 'required|string|size:10|unique:customers,phone,NULL,id,client_id,' . $this->input('client_id'),
            'devices_count' => 'integer|min:0',
        ];
    }
}
