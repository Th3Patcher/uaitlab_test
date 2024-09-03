<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyClaim\SearchWarrantyClaimsRequest;
use App\Repositories\WarrantyClaimsRepository;
use Inertia\Inertia;

class WarrantyClaimController extends Controller
{
    public function index()
    {
        return Inertia::render('Crm/WarrantyClaim/List');
    }

    public function create()
    {
        return Inertia::render('Crm/WarrantyClaim/Create');
    }

    public function search(SearchWarrantyClaimsRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository) {
        $validated = $request->validated();
        $warrantyClaims = $warrantyClaimsRepository->buildSearchQuery($validated)->paginate($request->input('per_page', 15));
        return response()->json($warrantyClaims);
    }
}
