<?php

namespace App\Http\Requests\Centers;

use App\Enums\CenterStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateCenterRequest extends FormRequest
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
            'name' => 'required|unique:centers,name|alpha',
            'status' => ['required', Rule::in(CenterStatus::values())],
            'address' => 'required',
            'start_work' => 'nullable|date_format:H:i',
            'end_work' => 'nullable|date_format:H:i|after:start_work',
        ];
    }
}
