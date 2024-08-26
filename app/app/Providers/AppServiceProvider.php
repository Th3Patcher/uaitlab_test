<?php

namespace App\Providers;

use App\Contracts\Parse\FileParse;
use App\Contracts\Parse\Managers\FileParseManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FileParse::class, function ($app) {
            return new FileParseManager();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
