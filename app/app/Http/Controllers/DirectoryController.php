<?php

namespace App\Http\Controllers;

use App\Models\DefectCodes;
use App\Models\SymptomCodes;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DirectoryController extends Controller
{
    public function index()
    {
        $defectCodes = DefectCodes::all();
        $symptomCodes = SymptomCodes::all();

        return Inertia::render('Directories/List', [
            'defectCodes' => $defectCodes,
            'symptomCodes' => $symptomCodes,
        ]);
    }
}
