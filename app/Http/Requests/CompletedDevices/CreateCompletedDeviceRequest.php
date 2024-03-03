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
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'required|string|alpha',
            'user_id' => 'nullable|exists:users,id',
            'user_name' => 'required|string|alpha',
            'info' => 'nullable|string',
            'problem' => 'required|string',
            'cost' => 'nullable|numeric',
            'status' => 'required|in:' . implode(',', DeviceStatus::values()),
            'fix_steps' => 'nullable|string',
            'date_receipt' => 'required|date',
            'date_delivery' => 'required|date',
            'date_warranty' => 'required|date',
            'deliver_to_client'=>'boolean',
            'deliver_to_customer'=>'boolean',
        ];
    }
}
