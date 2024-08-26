<?php

namespace App\Console\Commands;

use Exception;
use App\Contracts\Parser\FileParser;
use App\Services\Insert\InsertionData;
use Illuminate\Console\Command;

class ParseExcelCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'excel:parse {--t|truncate} {filename} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserting data from excel file into table. Flag -t is truncating the table before inserting data into table.
        At first, put file into \'storage/app/public/excel\' folder';

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(InsertionData $insertionData): void
    {
        $modelClass = "App\\Models\\{$this->argument('model')}";

        try {
            $fileParser = app()->make(FileParser::class, [
                'filename' => $this->argument('filename'),
                'class' => $modelClass,
            ]);

            $this->option('truncate') && $modelClass::truncate();

            $data = $fileParser->parse($modelClass);
            $insertionData->insertArrayIntoTable($data, $modelClass);

            $this->info('File was successfully parsed.');
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
