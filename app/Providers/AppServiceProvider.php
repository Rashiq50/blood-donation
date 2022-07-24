<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{

    public function register()
    {
    }

    public function boot()
    {
        if($this->app->environment('production')) {
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
    }
}
