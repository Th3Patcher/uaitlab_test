<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyClaims extends Model
{
    use HasFactory;

    public function serviceWorks()
    {
        return $this->hasMany(WarrantyClaimServiceWorks::class, 'warranty_claims_number_1c', 'number_1c');
    }

    public function spareParts()
    {
        return $this->hasMany(WarrantyClaimSpareparts::class, 'warranty_claims_number_1c', 'number_1c');
    }

    public function technicalConclusions()
    {
        return $this->hasOne(TechnicalConclusions::class, 'warranty_claims_code_1c', 'code_1c');
    }
}
