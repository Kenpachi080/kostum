<?php

namespace App\Providers;

use App\Services\DatabaseServices;
use App\Services\ImagesService;
use App\Services\ItemService;
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

        $this->app->bind('items', function () {
            return new ItemService();
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
