<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyClaimServiceWork\SearchListWarrantyClaimServiceWorkerRequest;
use App\Models\WarrantyClaimServiceWork;
use App\Repositories\WarrantyClaimsRepository;
use Illuminate\Support\Facades\DB;

class WarrantyClaimServiceWorkController extends Controller
{
    public function list(SearchListWarrantyClaimServiceWorkerRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository)
    {
        $serviceWorks = $warrantyClaimsRepository->listServiceWorks($request->get('line_number'), $request->get('product'));
        return response()->json($serviceWorks);
    }
}
