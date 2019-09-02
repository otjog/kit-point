<?php

namespace App\Providers;

use App\Models\GlobalData;
use Illuminate\Support\ServiceProvider;

class GlobalDataServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Models\GlobalData', function ($app) {
            return new GlobalData();
        });
    }
}
