<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyClaim\SearchWarrantyClaimsRequest;
use App\Http\Requests\WarrantyClaim\StoreWarrantyClaimRequest;
use App\Models\WarrantyClaim;
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

    public function store(StoreWarrantyClaimRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository)
    {
        try {
            $warrantyClaimsRepository->create($request->validated());
            return back()->with('success', 'Warranty Claim created.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error.');
        }
    }

    public function search(SearchWarrantyClaimsRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository) {
        $validated = $request->validated();
        $warrantyClaims = $warrantyClaimsRepository->buildSearchQuery($validated)->paginate($request->input('per_page', 15));
        return response()->json($warrantyClaims);
    }

    public function getServiceCenters()
    {
        return response()->json(
            WarrantyClaim::whereNotNull('point_of_sale')
            ->distinct('point_of_sale')
            ->pluck('point_of_sale')
        );
    }
}
