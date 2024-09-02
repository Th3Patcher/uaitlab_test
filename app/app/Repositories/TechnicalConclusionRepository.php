<?php

namespace App\Repositories;

use App\Http\Requests\TechnicalConclusion\SearchTechnicalConclusionRequest;
use App\Models\TechnicalConclusion;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TechnicalConclusionRepository
{
    public function buildSearchQuery($data)
    {
        $query = TechnicalConclusion::query();

        if (isset($data['date'])) {
            $query->whereDate('date', '>=', $data['date']);
        }

        if (isset($data['datefrom'])) {
            $query->whereDate('date', '>=', $data['datefrom']);
        }

        if (isset($data['dateto'])) {
            $dateto = $data['dateto'] ?? now()->format('Y-m-d');
            $query->whereDate('date', '<=', $dateto);
        }

        if (isset($data['code_1c'])) {
            $query->whereIn('code_1c', $data['code_1c']);
        }

        if (isset($data['appeal_type'])) {
            $query->where('appeal_type', $data['appeal_type']);
        }

        if (isset($data['sort_by']) && isset($data['sort_order'])) {
            $query->orderBy($data['sort_by'], $data['sort_order']);
        }

        return $query->with(['defectCodes', 'symptomCodes', 'warrantyClaim']);
    }

    public function store($data)
    {
        return DB::transaction(function () use ($data) {
            return (bool)TechnicalConclusion::create($data);
        });
    }
}
