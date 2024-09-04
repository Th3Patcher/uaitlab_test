<?php

namespace App\Http\Requests\WarrantyClaim;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarrantyClaimRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //GENERAL
            'document_date' => ['required', 'date'],
            'autor' => ['required', 'string', 'max:250'],
            'service_center' => ['required', 'string', 'max:250'],

            //DATA OF THE BUYER
            'client_name' => ['nullable', 'string', 'max:250'],
            'client_phone' => ['required', 'digits_between:10,15'],

            //DATA OF THE APPLICANT
            'sender_name' => ['nullable', 'string', 'max:250'],
            'sender_phone' => ['required', 'digits_between:10,15'],

            //PRODUCT DATA
            'product_article' => ['required', 'integer', 'min:0'],
            'product_name' => ['nullable', 'string', 'max:250'],
            'date_of_claim' => ['required', 'date', 'after:date_of_sale'],
            'date_of_sale' => ['required', 'date'],
            'factory_number' => ['nullable', 'string', 'max:30'],
            'point_of_sale' => ['nullable', 'string', 'exists:warranty_claims,point_of_sale'],
            'receipt_number' => ['nullable', 'string', 'max:250'],

            //DEFECT DESC
            'exact_desc' => ['required', 'string'],
            'reason_defect' => ['required', 'string'],

            //OTHER
            'comment' => ['nullable', 'string'],

            //SERVICE WORKS
            'serviceworks' => ['nullable', 'array'],
            'group' => ['nullable', 'integer', 'min:0'],

            //SPAREPARTS
            'spareparts' => ['nullable', 'array'],
            'spareparts.*.articul' => ['required', 'string', 'max:50'],
            'spareparts.*.product' => ['required', 'string', 'max:250'],
            'spareparts.*.discount' => ['required', 'integer', 'min:0'],
            'spareparts.*.price' => ['required', 'numeric', 'min:0'],
            'spareparts.*.qty' => ['required', 'integer', 'min:0'],
        ];
    }
}
