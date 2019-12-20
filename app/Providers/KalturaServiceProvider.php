<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class KalturaServiceProvider extends ServiceProvider
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
        $this->app->singleton('kaltura', function () {
            return new \App\Services\Kaltura();
        });
    }
}
