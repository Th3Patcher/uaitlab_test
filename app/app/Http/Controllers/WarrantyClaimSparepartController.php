<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarrantyClaimSparepart\SearchListWarrantyClaimSparepartRequest;
use App\Models\WarrantyClaimSparepart;
use App\Repositories\WarrantyClaimsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarrantyClaimSparepartController extends Controller
{
    public function list(SearchListWarrantyClaimSparepartRequest $request, WarrantyClaimsRepository $warrantyClaimsRepository)
    {
        $spareparts = $warrantyClaimsRepository->listSpareParts($request->get('articul'));
        return response()->json($spareparts);
    }
}
