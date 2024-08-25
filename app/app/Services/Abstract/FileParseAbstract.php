<?php

namespace App\Services\Abstract;

abstract class FileParseAbstract
{
    /**
     * Name of the table which going to fill
     *
     * @var string
     */
    protected string $tableName;

    /**
     * Parsing a file and getting data of each row
     */
    abstract public function parseFile();

    /**
     * Opening a file for reading data
     */
    abstract protected function openFile();

    /**
     * Finding the difference between a table and a file
     * if false, then the file doesn't match the table
     *
     * @param $worksheet
     * @return bool
     */
    protected function diffBetweenTableAndFileHeaders($worksheet): bool
    {
        $row = $worksheet->getRowIterator(1)->current();
        $cellIterator = $row->getCellIterator();

        $columns = array();
        foreach ($cellIterator as $cell) {
            $columns[] = $cell->getValue();
        }

        return !array_diff($columns, \Schema::getColumnListing($this->tableName));
    }
}
