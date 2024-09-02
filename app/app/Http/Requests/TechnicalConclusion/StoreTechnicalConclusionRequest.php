<?php

namespace App\Http\Requests\TechnicalConclusion;

use Illuminate\Foundation\Http\FormRequest;

class StoreTechnicalConclusionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'code_1c' => ['required', 'unique:technical_conclusions,code_1c', 'string', 'uuid'],
            'number_1c' => ['required', 'unique:technical_conclusions,number_1c', 'string', 'max:25'],
            'date' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
            'defect_codes_code_1c' => ['required', 'string', 'uuid', 'exists:defect_codes,code_1C'],
            'symptom_codes_code_1c' => ['required', 'string', 'uuid', 'exists:symptom_codes,code_1C'],
            'warranty_claims_code_1c' => ['required', 'string', 'uuid', 'exists:warranty_claims,code_1c'],
            'conclusion' => ['nullable', 'string'],
            'resolution' => ['nullable', 'string'],
            'appeal_type' => ['nullable', 'string', 'max:20'],
        ];
    }
}
