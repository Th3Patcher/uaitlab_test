<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_1c',
        'number_1c',
        'date',
        'date_of_claim',
        'date_of_sale',
        'factory_number',
        'comment',
        'point_of_sale',
        'product_name',
        'details',
        'manager',
        'autor',
        'client_name',
        'client_phone',
        'sender_name',
        'sender_phone',
        'receipt_number',
        'service_contract',
        'service_partner',
        'product_article',
        'status',
        'spare_parts_sum',
        'service_works_sum',
    ];

    public $timestamps = false;

    public function serviceWorks()
    {
        return $this->hasMany(WarrantyClaimServiceWork::class, 'warranty_claims_number_1c', 'number_1c');
    }

    public function spareParts()
    {
        return $this->hasMany(WarrantyClaimSparepart::class, 'warranty_claims_number_1c', 'number_1c');
    }

    public function technicalConclusions()
    {
        return $this->hasOne(TechnicalConclusion::class, 'warranty_claims_code_1c', 'code_1c');
    }
}
