<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TechnicalConclusion extends Model
{
    use HasFactory;

    public function defectCodes()
    {
        return $this->hasOne(DefectCode::class, 'code_1C', 'defect_codes_code_1c');
    }

    public function symptomCodes()
    {
        return $this->hasOne(SymptomCode::class, 'code_1C', 'symptom_codes_code_1c');
    }

    public function warrantyClaim()
    {
        return $this->hasOne(WarrantyClaim::class, 'code_1c', 'warranty_claims_code_1c');
    }
}
