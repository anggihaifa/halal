<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Log;
//use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        /*If (env('APP_ENV') != 'local') {
            $this->app['request']->server->set('HTTPS', true);
        }
        Schema::defaultStringLength(191);*/

        
        
        /*if(env('FORCE_HTTPS',false)) { // Default value should be false for local server
            URL::forceSchema('https');
        }*/
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
