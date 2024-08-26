<?php

namespace App\Http\Controllers;

use App\Models\WarrantyClaims;
use App\Repositories\WarrantyClaimsRepository;
use App\Http\Requests\WarrantyClaimsSearchRequest;

class WarrantyClaimsController extends Controller
{
    public function search(WarrantyClaimsSearchRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository) {
        $validated = $request->validated();
        $warrantyClaims = $warrantyClaimsRepository->buildSearchQuery($validated);
        return response()->json($warrantyClaims);
    }

    public function store() {

    }
}
