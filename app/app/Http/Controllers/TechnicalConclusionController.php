<?php

namespace App\Http\Controllers;

use App\Http\Requests\TechnicalConclusion\SearchTechnicalConclusionRequest;
use App\Http\Requests\TechnicalConclusion\StoreTechnicalConclusionRequest;
use App\Repositories\TechnicalConclusionRepository;

class TechnicalConclusionController extends Controller
{
    public function search(SearchTechnicalConclusionRequest $request, TechnicalConclusionRepository $repository)
    {
        $validated = $request->validated();
        $technicalConclusions = $repository->buildSearchQuery($validated)->paginate($request->input('per_page', 15));
        return response()->json($technicalConclusions, 200);
    }

    public function store(StoreTechnicalConclusionRequest $request, TechnicalConclusionRepository $repository)
    {
        $validated = $request->validated();
        $technicalConclusion = $repository->store($validated);

        if ($technicalConclusion) {
            return response()->json(['message' => 'Conclusion created', 'code' => 200]);
        }

        return response()->json(['message' => 'Failed to create conclusion', 'code' => 500]);
    }
}
