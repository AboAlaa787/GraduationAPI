<?php

namespace App\Http\Requests\Centers;

use App\Enums\CenterStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCenterRequest extends FormRequest
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
            'status' => [ Rule::in(CenterStatus::values())],
            'start_work' => 'filled|date_format:h:i A',
            'end_work' => 'filled|date_format:h:i A|after:start_work',
        ];
    }
}
