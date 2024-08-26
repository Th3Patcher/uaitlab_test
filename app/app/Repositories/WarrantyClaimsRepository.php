<?php

namespace App\Repositories;

use App\Models\WarrantyClaims;

class WarrantyClaimsRepository
{
    public function buildSearchQuery($validated): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = WarrantyClaims::query();

        if (isset($validated['date'])) {
            $query->whereDate('date', '>=', $validated['date']);
        }

        if (isset($validated['datefrom'])) {
            $query->whereDate('date', '>=', $validated['datefrom']);
        }

        if (isset($validated['dateto'])) {
            $dateto = $validated['dateto'] ?? now()->format('Y-m-d');
            $query->whereDate('date', '<=', $dateto);
        }

        if (isset($validated['status'])) {
            $query->where('status', $validated['status']);
        }

        if (isset($validated['code_1c'])) {
            $query->whereIn('code_1c', $validated['code_1c']);
        }

        return $query->with(['serviceWorks', 'spareParts', 'technicalConclusions'])->get();
    }
}
