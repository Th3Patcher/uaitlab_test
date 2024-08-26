<?php

namespace App\Contracts\Parse;

abstract class FileParse
{
    /**
     * Opening a file for reading data
     */
    abstract protected function openFile($fileName);

    /**
     * Parsing a file and getting data of each row
     */
    abstract public function parseFile($class, $fileName);

    /**
     * Finding the difference between a table and a file
     * if false, then the file doesn't match the table
     *
     * @param $worksheet
     * @param $tableName
     * @return bool
     */
    protected function diffBetweenTableAndFileHeaders($worksheet, $tableName): bool
    {
        $row = $worksheet->getRowIterator(1)->current();
        $cellIterator = $row->getCellIterator();

        $columns = array();
        foreach ($cellIterator as $cell) {
            $columns[] = $cell->getValue();
        }

        return !array_diff($columns, \Schema::getColumnListing($tableName));
    }
}
