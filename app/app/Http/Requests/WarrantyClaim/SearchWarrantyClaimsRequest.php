<?php

namespace App\Http\Requests\WarrantyClaim;

use App\Enums\Warranty\WarrantyClaimsStatus;
use App\Models\WarrantyClaim;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SearchWarrantyClaimsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *a
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => ['nullable', 'date_format:Y-m-d'],
            'datefrom' => ['nullable', 'date_format:Y-m-d'],
            'dateto' => ['nullable', 'date_format:Y-m-d', 'after_or_equal:datefrom'],
            'status' => ['nullable', new Enum(WarrantyClaimsStatus::class)],
            'code_1c' => ['nullable', 'array'],
            'code_1c.*' => ['uuid'],
            'sort_by' => ['nullable', 'string', Rule::in(\Schema::getColumnListing((new WarrantyClaim)->getTable()))],
            'sort_order' => ['nullable', 'string', 'in:asc,desc'],
            'per_page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
