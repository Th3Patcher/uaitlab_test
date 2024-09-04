<?php

namespace App\Http\Requests\WarrantyClaimServiceWork;

use Illuminate\Foundation\Http\FormRequest;

class SearchListWarrantyClaimServiceWorkerRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'line_number' => ['required', 'integer', 'min:1'],
            'product' => ['nullable', 'string', 'min:3', 'max:255', 'default' => ''],
        ];
    }
}
