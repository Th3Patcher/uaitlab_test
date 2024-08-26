<?php

namespace App\Http\Requests;

use App\Enums\WarrantyClaimsStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class WarrantyClaimsSearchRequest extends FormRequest
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
            'status' => ['nullable', new Enum(WarrantyClaimsStatus::class)],
            'code_1c' => ['nullable', 'array'],
            'code_1c.*' => ['uuid'],
        ];
    }
}
