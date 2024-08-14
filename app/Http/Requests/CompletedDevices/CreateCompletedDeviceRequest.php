<?php

namespace App\Http\Requests\CompletedDevices;

use App\Enums\DeviceStatus;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompletedDeviceRequest extends FormRequest
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
            'model' => 'required|string',
            'imei' => 'nullable|string|max:15|min:15',
            'code' => 'required|unique:devices,code',
            'client_id' => 'integer|required|exists:clients,id',
            'client_name' => 'required|string',
            'user_id' => 'integer|required|exists:users,id',
            'user_name' => 'required|string',
            'info' => 'nullable|string',
            'problem' => 'required|string',
            'cost_to_client' => 'required|numeric',
            'cost_to_customer' => 'nullable|numeric',
            'status' => 'required|in:' . implode(',', DeviceStatus::values()),
            'fix_steps' => 'nullable|string',
            'date_receipt' => 'date',
            'date_receipt_from_customer' => 'required|date',
            'date_delivery' => 'date',
            'date_warranty' => 'date',
            'deliver_to_client'=>'boolean',
            'deliver_to_customer'=>'boolean',
            'customer_id' => 'integer|nullable|exists:customers,id',
            'repaired_in_center' => 'required|boolean',
            'customer_complaint'=>'required|string',
        ];
    }
}
