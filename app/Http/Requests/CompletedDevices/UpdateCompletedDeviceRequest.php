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
            'model' => 'string',
            'imei' => 'nullable|string',
            'code' => 'unique:devices,code',
            'client_id' => 'nullable|exists:clients,id',
            'client_name' => 'string',
            'user_id' => 'nullable|exists:users,id',
            'user_name' => 'string',
            'info' => 'nullable|string',
            'problem' => 'string',
            'cost' => 'nullable|numeric',
            'status' => 'in:' . implode(',', DeviceStatus::values()),
            'fix_steps' => 'nullable|string',
            'date_receipt' => 'date',
            'date_delivery' => 'date',
            'date_warranty' => 'date',
        ];
    }
}
