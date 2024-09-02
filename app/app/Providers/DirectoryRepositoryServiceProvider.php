<?php

namespace App\Providers;

use App\Repositories\DirectoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class DirectoryRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

        $this->app->bind(DirectoryRepository::class, function ($app) {
            $request = $app->make(Request::class);
            return new DirectoryRepository($request->input('type', 'Defect'));
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
