<?php

namespace App\Providers;

use App\Contracts\Parser\FileParser;
use App\Services\Parser\ExcelParser;
use Illuminate\Support\ServiceProvider;

class FileParserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(FileParser::class, function ($app, $params) {
            $filename = $params['filename'];
            $class = $params['class'];

            $extension = pathinfo($filename, PATHINFO_EXTENSION);

            return match ($extension) {
                'xlsx', 'xls' => new ExcelParser($filename, $class),
                // 'type' => new YourParser($filename, $class), <-- ADD PARSER HERE
                default => throw new \Exception("Unsupported file format: {$extension}"),
            };
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
