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
            'model' => 'string',
            'imei' => 'nullable|string',
            'code' => 'unique:devices,code',
            'client_id' => 'exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'client_priority' => 'integer',
            'manager_priority' => 'integer|unique:devices,manager_priority,NULL,id,user_id,' . $this->get('user_id'),
            'info' => 'nullable|string',
            'problem' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'fix_steps' => 'nullable|string',
            'status' => 'in:' . implode(',', DeviceStatus::values()),
            'client_approval' => 'boolean',
            'date_receipt' => 'date',
            'warranty_days' => 'integer',
        ];
    }
}
