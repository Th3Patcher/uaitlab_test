<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyClaim\WarrantyClaimsSearchRequest;
use App\Repositories\WarrantyClaimsRepository;

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
