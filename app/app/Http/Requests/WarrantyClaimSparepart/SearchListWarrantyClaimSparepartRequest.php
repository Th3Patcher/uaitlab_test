<?php

namespace App\Http\Requests\WarrantyClaimSparepart;

use Illuminate\Foundation\Http\FormRequest;

class SearchListWarrantyClaimSparepartRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'articul' => ['required', 'string', 'exists:warranty_claim_spareparts,articul']
        ];
    }
}
