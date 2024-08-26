<?php

namespace App\Contracts\Parser;

interface FileParser
{
    /**
     * Parsing a file and getting data of each row
     *
     * @param $class
     * @return mixed
     */
    public function parse($class): mixed;

    /**
     * Finding the difference between a table and a file
     * if false, then the file doesn't match the table
     *
     * @param $worksheet
     * @param string $tableName
     * @return bool
     */
    public function checkHeaders($worksheet, string $tableName): bool;
}
