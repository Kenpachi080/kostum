<?php

namespace App\Providers;

use App\Services\DatabaseServices;
use App\Services\ImagesService;
use App\Services\PageService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('images', function () {
            return new ImagesService();
        });

        $this->app->bind('databases', function () {
            return new DatabaseServices();
        });

        $this->app->bind('pages', function () {
            return new PageService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
