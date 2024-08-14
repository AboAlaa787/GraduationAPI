<?php

namespace App\Http\Requests\CompletedDevices;

use App\Enums\DeviceStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCompletedDeviceRequest extends FormRequest
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
            'model' => 'string|filled',
            'imei' => 'nullable|string|max:15|min:15',
            'code' => 'unique:devices,code|filled',
            'client_id' => 'integer|filled|exists:clients,id',
            'client_name' => 'string|filled',
            'user_id' => 'integer|filled|exists:users,id',
            'user_name' => 'string|filled',
            'info' => 'nullable|string',
            'problem' => 'string|filled',
            'cost_to_client' => 'filled|numeric',
            'cost_to_customer' => 'nullable|numeric',
            'status' => 'filled|in:' . implode(',', DeviceStatus::values()),
            'fix_steps' => 'nullable|string',
            'date_receipt' => 'date',
            'date_receipt_from_customer' => 'date|filled',
            'date_delivery' => 'date|filled',
            'date_warranty' => 'date|filled',
            'deliver_to_client'=>'boolean',
            'deliver_to_customer'=>'boolean',
            'customer_id' => 'nullable|exists:customers,id',
            'repaired_in_center' => 'filled|boolean',
        ];
    }
}
