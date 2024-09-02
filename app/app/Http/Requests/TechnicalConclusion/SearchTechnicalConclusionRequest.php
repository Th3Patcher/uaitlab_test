<?php

namespace App\Http\Requests\TechnicalConclusion;

use App\Models\TechnicalConclusion;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SearchTechnicalConclusionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date_format:Y-m-d'],
            'datefrom' => ['nullable', 'date_format:Y-m-d'],
            'dateto' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:datefrom'],
            'appeal_type' => ['nullable', 'string'],
            'code_1c' => ['nullable', 'array'],
            'code_1c.*' => ['uuid'],
            'sort_by' => ['nullable', 'string', Rule::in(\Schema::getColumnListing((new TechnicalConclusion)->getTable()))],
            'sort_order' => ['nullable', 'string', 'in:asc,desc'],
            'per_page' => ['nullable', 'integer', 'min:1', 'default'],
        ];
    }
}
