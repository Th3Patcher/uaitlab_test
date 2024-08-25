<?php

namespace App\Services;

use Exception;
use App\Models;
use App\Services\Abstract\FileParseAbstract;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ExcelParseService extends FileParseAbstract
{

    private string $fileName;

    public function __construct($class, string $fileName)
    {
        $this->tableName = (new $class)->getTable();
        $this->fileName = $fileName;
    }

    protected function openFile(): Spreadsheet
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        return $reader->load(storage_path('app/public/excel/' . $this->fileName));
    }

    /**
     * @return array
     * @throws Exception
     */
    public function parseFile(): array
    {
        //Data of each row
        $data = array();

        $worksheet = $this->openFile()->getActiveSheet();

        if (!$this->diffBetweenTableAndFileHeaders($worksheet)) {
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
