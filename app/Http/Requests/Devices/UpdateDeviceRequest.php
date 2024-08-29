<?php

namespace App\Http\Requests\Devices;

use App\Enums\DeviceStatus;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDeviceRequest extends FormRequest
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
            'model' => 'filled|string',
            'code' => 'filled|string|unique:devices,code',
            'client_id' => 'integer|filled|exists:clients,id',
            'user_id' => 'integer|filled|exists:users,id',
            'customer_id' => 'integer|filled|exists:customers,id',
            'client_priority' => 'filled|integer',
            'info' => 'nullable|string',
            'problem' => 'nullable|string',
            'cost_to_client' => 'nullable|numeric',
            'cost_to_customer' => 'nullable|numeric',
            'fix_steps' => 'nullable|string',
            'status' => 'filled|in:' . implode(',', DeviceStatus::values()),
            'client_approval' => 'filled|boolean',
            'date_receipt' => 'nullable|date',
            'date_receipt_from_customer' => 'filled|date',
            'deliver_to_client' => 'filled|boolean',
            'deliver_to_customer' => 'filled|boolean',
            'imei' => 'nullable|string|size:15',
            'Expected_date_of_delivery' => 'nullable|date',
            'repaired_in_center' => 'boolean|filled',
            'payment_status' => 'filled|boolean',
        ];
    }
}
