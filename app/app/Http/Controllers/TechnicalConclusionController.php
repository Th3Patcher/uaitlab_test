<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnicalConclusion\SearchTechnicalConclusionRequest;
use App\Repositories\TechnicalConclusionRepository;

class TechnicalConclusionController extends Controller
{
    public function search(SearchTechnicalConclusionRequest $request, TechnicalConclusionRepository $repository)
    {
        $validated = $request->validated();
        $technicalConclusions = $repository->buildSearchQuery($validated)->paginate($request->input('per_page', 15));
        return response()->json($technicalConclusions);
    }
}
