<?php

namespace App\Contracts\Parse\Managers;

use App\Services\Parse\ExcelParse;

class FileParseManager
{
    /**
     * Chooses appropriate extension for parse service.
     * You can implement your service for another extension
     * and add it in match clause
     *
     * @param string $filename
     * @return ExcelParse
     * @throws \Exception
     */
    public function make(string $filename): ExcelParse
    {
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        return match ($extension) {
            'xlsx', 'xls' => new ExcelParse(),
            //'type' => new YourParse(), <-- ADD HERE YOUR PARSER
            default => throw new \Exception("Unsupported file format: {$extension}"),
        };
    }
}
