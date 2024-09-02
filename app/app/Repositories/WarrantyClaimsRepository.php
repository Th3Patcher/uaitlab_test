<?php

namespace App\Repositories;

use App\Models\WarrantyClaim;
use Dflydev\DotAccessData\Exception\DataException;

class WarrantyClaimsRepository
{
    public function buildSearchQuery($data)
    {
        $query = WarrantyClaim::query();

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

        if (isset($data['status'])) {
            $query->where('status', $data['status']);
        }

        if (isset($data['sort_by']) && isset($data['sort_order'])) {
            $query->orderBy($data['sort_by'], $data['sort_order']);
        }

        return $query->with(['serviceWorks', 'spareParts', 'technicalConclusions']);
    }
}
