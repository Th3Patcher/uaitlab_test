<?php

namespace App\Console\Commands;

use Exception;
use App\Models\WarrantyClaims;
use App\Services\ExcelParseService;
use App\Services\InsertionDataService;
use Illuminate\Console\Command;

class ParseExcel extends Command
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
    public function handle()
    {
        $truncate = $this->option('truncate');
        $filename = $this->argument('filename');
        $model = $this->argument('model');

        $modelClass = "App\\Models\\{$model}";

        // Check whether the model class exists and is inherited from the base model
        if (!class_exists($modelClass) || !is_subclass_of($modelClass, \Illuminate\Database\Eloquent\Model::class)) {
            $this->error("The provided model '{$modelClass}' is not valid.");
            return;
        }

        try {
            if ($truncate) {
                $modelClass::truncate();
            }

            $data = (new ExcelParseService($modelClass, $filename))->parseFile();
            (new InsertionDataService())->insertArrayIntoTable($data, $modelClass);

            $this->info('File was successfully parsed.');
        } catch (Exception $exception) {
            $this->error($exception->getMessage());
        }
    }
}
