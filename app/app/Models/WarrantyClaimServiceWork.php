<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WarrantyClaimServiceWork extends Model
{
    use HasFactory;

    protected $fillable = [
        'code_1c',
        'warranty_claims_number_1c',
        'line_number',
        'articul',
        'product',
        'qty',
        'price',
        'sum'
    ];

    public $timestamps = false;
}
