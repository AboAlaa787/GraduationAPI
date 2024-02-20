<?php

namespace App\Http\Requests\Devices;

use App\Enums\DeviceStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateDeviceRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'model' => 'required|string',
            'imei' => 'nullable|string',
            'code' => 'required|unique:devices,code',
            'client_id' => 'required|exists:clients,id',
            'user_id' => 'nullable|exists:users,id',
            'client_priority' => 'required|integer|unique:devices,client_priority,NULL,id,client_id,' . $this->get('client_id'),
            'manager_priority' => 'integer|unique:devices,manager_priority,NULL,id,user_id,' . $this->get('user_id'),
            'info' => 'nullable|string',
            'problem' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'fix_steps' => 'nullable|string',
            'status' => 'required|in:' . implode(',', DeviceStatus::values()),
            'client_approval' => 'boolean|required',
            'date_receipt' => 'date',
            'warranty_days' => 'integer',
        ];
    }
}
