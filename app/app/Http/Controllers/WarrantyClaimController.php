<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyClaim\SearchWarrantyClaimsRequest;
use App\Repositories\WarrantyClaimsRepository;

class WarrantyClaimController extends Controller
{
    public function search(SearchWarrantyClaimsRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository) {
        $validated = $request->validated();
        $warrantyClaims = $warrantyClaimsRepository->buildSearchQuery($validated)->paginate($request->input('per_page', 15));
        return response()->json($warrantyClaims);
    }

    public function store() {

    }
}
