<?php

namespace App\Services\Parse;

use Exception;
use App\Contracts\Parse\FileParse;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelParse extends FileParse
{
    protected function openFile($fileName): Spreadsheet
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        return $reader->load(storage_path('app/public/excel/' . $fileName));
    }

    /**
     * @param $class
     * @param $fileName
     * @return array
     * @throws Exception
     */
    public function parseFile($class, $fileName): array
    {
        //Will save data of each row
        $data = array();

        $worksheet = $this->openFile($fileName)->getActiveSheet();

        if (!$this->diffBetweenTableAndFileHeaders($worksheet, (new $class)->getTable())) {
            throw new Exception('There are difference between the file\'s and table\'s columns.');
        }

        //Starting iterating from second row
        foreach ($worksheet->getRowIterator(2) as $row) {
            $cellIterator = $row->getCellIterator();
            $rowData = [];

            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            $data[] = $rowData;
        }

        return $data;
    }
}
