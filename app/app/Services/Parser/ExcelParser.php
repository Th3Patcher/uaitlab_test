<?php

namespace App\Services\Parser;

use Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelParser extends BaseParser
{
    /**
     * @param $class
     * @return array
     * @throws Exception
     */
    public function parse($class): array
    {
        //Will save data of each row
        $data = array();

        $worksheet = $this->readFile()->getActiveSheet();
        $this->validateHeaders($worksheet);

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

    /**
     * @param $worksheet
     * @param string $tableName
     * @return bool
     */
    public function checkHeaders($worksheet, string $tableName): bool
    {
        $row = $worksheet->getRowIterator(1)->current();
        $cellIterator = $row->getCellIterator();

        $columns = array();
        foreach ($cellIterator as $cell) {
            $columns[] = $cell->getValue();
        }

        return (bool)array_diff($columns, \Schema::getColumnListing($tableName));
    }

    /**
     * Opening a file for reading data
     *
     * @return Spreadsheet
     */
    private function readFile(): Spreadsheet
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        return $reader->load(storage_path('app/public/excel/' . $this->fileName));
    }
}
