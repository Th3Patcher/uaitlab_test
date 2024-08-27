<?php

namespace App\Services\Parser;

use App\Contracts\Parser\FileParser;
use Illuminate\Database\Eloquent\Model;

abstract class BaseParser implements FileParser
{
    /**
     * @var string
     */
    protected string $fileName;

    /**
     * @var string|Model
     */
    protected string|Model $class;

    /**
     * @param string $fileName
     * @param string $class
     * @throws \Exception
     */
    public function __construct(string $fileName, string $class)
    {
        // Check whether the model class is inherited from the base model
        if (!is_subclass_of($class, Model::class)) {
            throw new \Exception("The provided class '{$class}' does not exist or is not a valid model class.");
        }

        $this->fileName = $fileName;
        $this->class = $class;
    }

    /**
     * @param $worksheet
     * @return void
     * @throws \Exception
     */
    protected function validateHeaders($worksheet): void
    {
        if ($this->checkHeaders($worksheet, (new $this->class)->getTable())) {
            throw new \Exception('There are differences between the file\'s and table\'s columns.');
        }
    }
}
