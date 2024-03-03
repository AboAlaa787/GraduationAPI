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
            'code' => 'required|unique:devices',
            'client_id' => 'required|exists:clients,id',
            'client_priority' => 'required|integer',
            'info' => 'nullable|string',
            'problem' => 'nullable|string',
            'cost' => 'nullable|numeric',
            'fix_steps' => 'nullable|string',
            'status' => 'required|in:' . implode(',', DeviceStatus::values()),
            'client_approval' => 'nullable|boolean',
            'date_receipt' => 'nullable|date',
            'deliver_to_client' => 'nullable|boolean',
            'deliver_to_customer' => 'nullable|boolean',
            'required_period' => 'nullable|integer',
        ];
    }
}
