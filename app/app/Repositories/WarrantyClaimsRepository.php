<?php

namespace App\Repositories;

use App\Models\WarrantyClaim;
use App\Models\WarrantyClaimServiceWork;
use App\Models\WarrantyClaimSparepart;
use DateTime;
use Dflydev\DotAccessData\Exception\DataException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class WarrantyClaimsRepository
{
    //Saving warranty claim number 1c
    protected $warrantyClaimNumber = '';

    /**
     * @param $data
     * @return \Illuminate\Database\Eloquent\Builder
     */
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

    /**
     * @param $data
     * @throws \Exception
     */
    public function create($data): void
    {
        DB::beginTransaction();

        try {
            //Generate 1c fields
            $code_1c = Str::uuid();
            $number_1c = substr($code_1c, 0, 8);

            $this->warrantyClaimNumber = $number_1c;

            //Get service_partner and service_contract by point_of_sale
            $servicePartners = WarrantyClaim::where('point_of_sale', $data['point_of_sale'])
                ->first(['service_partner', 'service_contract'])
                ->toArray();

            $claim = new WarrantyClaim([
                'code_1c' => $code_1c,
                'number_1c' => $number_1c,
                'date' => (new Datetime($data['document_date']))->format('Y-m-d H:i:s'),
                'date_of_claim' => (new Datetime($data['date_of_claim']))->format('Y-m-d H:i:s'),
                'date_of_sale' => (new Datetime($data['date_of_sale']))->format('Y-m-d H:i:s'),
                'factory_number' => $data['factory_number'],
                'comment' => $data['comment'],
                'point_of_sale' => $data['point_of_sale'],
                'product_name' => $data['product_name'],
                'details' => $data['reason_defect'] . "\n ------------------------------ \n" . $data['exact_desc'],
                'manager' => $data['autor'],
                'autor' => $data['autor'],
                'client_name' => $data['client_name'],
                'client_phone' => $data['client_phone'],
                'sender_name' => $data['sender_name'],
                'sender_phone' => $data['sender_phone'],
                'receipt_number' => $data['receipt_number'],
                'service_contract' => $servicePartners['service_contract'],
                'service_partner' => $servicePartners['service_partner'],
                'product_article' => $data['product_article'],
                'status' => 'Ложь',
                'spare_parts_sum' => $this->findTotalSparePartsSum($data['spareparts']),
                'service_works_sum' => $this->findTotalServiceWorksSum($data['serviceworks'], $data['group'])
            ]);

            $claim->save();
            $this->createServiceWork($data['serviceworks'], $data['group']);
            $this->createSparePart($data['spareparts']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Searching service works by group (line_number) and product
     *
     * @param $group
     * @param $poduct
     * @return mixed
     */
    public function listServiceWorks($group, $poduct)
    {
        return WarrantyClaimServiceWork::select('code_1c', 'line_number', 'product', DB::raw('MIN(price) as price'))
            ->where('line_number', $group)
            ->where('product', 'like', "%{$poduct}%")
            ->groupBy('code_1c', 'line_number', 'product')->get();
    }

    /**
     * Searching spareparts by articul
     *
     * @param $articul
     * @return mixed
     */
    public function listSpareParts($articul)
    {
        return WarrantyClaimSparepart::select(
            'articul',
            'product',
            DB::raw('MAX(price) as price'),
            DB::raw('SUM(qty) as qty'),
            DB::raw('MIN(discount) as discount'))
            ->where('articul',)
            ->groupBy('articul', 'product')->get();
    }

    /**
     * Create service works after initializing warranty claim
     *
     * @param $serviceWorks
     * @param $group
     * @return void
     */
    private function createServiceWork($serviceWorks, $group)
    {
        $existingServiceWorks = $this->findExistedServiceWorksForPricing($group, $serviceWorks);

        foreach ($serviceWorks as $serviceWorkData) {
            $code1c = $serviceWorkData[0];
            $hours = $serviceWorkData[1];

            //Search our code_1c in $existingServiceWorks
            if (isset($existingServiceWorks[$code1c])) {
                $existingServiceWork = $existingServiceWorks[$code1c];

                $sum = $existingServiceWork->price * $hours;

                WarrantyClaimServiceWork::create([
                    'code_1c' => $code1c,
                    'warranty_claims_number_1c' => $this->warrantyClaimNumber,
                    'line_number' => $group,
                    'articul' => $existingServiceWork->articul,
                    'product' => $existingServiceWork->product,
                    'qty' => $hours,
                    'price' => $existingServiceWork->price,
                    'sum' => $sum,
                ])->save();
            }
        }
    }

    /**
     * @param $spareparts
     * @return void
     */
    private function createSparePart($spareparts)
    {
        foreach ($spareparts as $key => $sparepart) {
            $sum = ($sparepart['price'] * $sparepart['qty']) * (1 - $sparepart['discount'] / 100);

            WarrantyClaimSparePart::create([
                'code_1c' => Str::uuid(),
                'warranty_claims_number_1c' => $this->warrantyClaimNumber,
                'line_number' => $key,
                'articul' => $sparepart['articul'],
                'product' => $sparepart['product'],
                'qty' => $sparepart['qty'],
                'price' => $sparepart['price'],
                'sum' => $sum,
                'discount' => $sparepart['discount'],
            ])->save();
        }
    }

    /**
     * @param $spareparts
     * @return float
     */
    private function findTotalSparePartsSum($spareparts): float
    {
        //Calculating total sum with discount
        return array_reduce($spareparts,
            fn($carry, $part) => $carry + ($part['price'] * (1 - $part['discount'] / 100)
                    * (int)$part['qty']), 0);
    }

    /**
     * @param $serviceWorks
     * @param $group
     */
    private function findTotalServiceWorksSum($serviceWorks, $group)
    {
        $existingServiceWorks = $this->findExistedServiceWorksForPricing($group, $serviceWorks);

        //Calculating total sum by price * hours
        return collect($serviceWorks)
            ->filter(fn($serviceWork) => $existingServiceWorks->has($serviceWork[0]))
            ->reduce(function ($totalSum, $serviceWork) use ($existingServiceWorks) {
                $code1c = $serviceWork[0];
                $hours = $serviceWork[1];
                $sum = $existingServiceWorks[$code1c]->price * $hours;
                return $totalSum + $sum;
            }, 0.0);
    }

    /**
     * Find existed service works for pricing
     *
     * @param $group
     * @param $serviceWorks
     * @return mixed
     */
    private function findExistedServiceWorksForPricing($group, $serviceWorks): mixed
    {
        return WarrantyClaimServiceWork::where('line_number', $group)
            ->whereIn('code_1c', array_column($serviceWorks, 0))
            ->get()
            ->keyBy('code_1c');
    }

}
