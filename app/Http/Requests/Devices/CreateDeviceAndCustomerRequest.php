<?php

namespace App\Http\Requests\Devices;

use App\Enums\DeviceStatus;
use Illuminate\Foundation\Http\FormRequest;

class CreateDeviceAndCustomerRequest extends FormRequest
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
            'client_id' => 'integer|required|exists:clients,id',
            'user_id' => 'integer|nullable|exists:users,id',
            'info' => 'nullable|string',
            'problem' => 'nullable|string',
            'cost_to_client' => 'nullable|numeric',
            'cost_to_customer' => 'nullable|numeric',
            'fix_steps' => 'nullable|string',
            'status' => 'in:' . implode(',', DeviceStatus::values()),
            'client_approval' => 'nullable|boolean',
            'date_receipt' => 'nullable|date',
            'date_receipt_from_customer' => 'nullable|date',
            'deliver_to_client' => 'nullable|boolean',
            'deliver_to_customer' => 'nullable|boolean',
            'imei' => 'nullable|string',
            'Expected_date_of_delivery' => 'nullable|date',
            'repaired_in_center' => 'required|boolean',
            'name' => 'required|string|max:20|min:2',
            'last_name' => 'required|string|max:20|min:2',
            'national_id' => 'nullable|string|size:11,',
            'phone' => 'required|string|size:10',
            'devices_count' => 'integer|min:0',
            'customer_complaint'=>'required|string',
        ];
    }
}
