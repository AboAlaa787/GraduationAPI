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
            'imei' => 'nullable|string',
            'code' => 'unique:devices,code|filled',
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'string|filled|alpha',
            'user_id' => 'nullable|exists:users,id',
            'user_name' => 'string|filled|alpha',
            'info' => 'nullable|string',
            'problem' => 'string|filled',
            'cost' => 'nullable|numeric',
            'status' => 'in:' . implode(',', DeviceStatus::values()),
            'fix_steps' => 'nullable|string',
            'date_receipt' => 'date|filled',
            'date_delivery' => 'date|filled',
            'date_warranty' => 'date|filled',
        ];
    }
}
