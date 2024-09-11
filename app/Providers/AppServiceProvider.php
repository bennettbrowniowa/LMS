<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;

use Laravel\Socialite\Facades\Socialite;
use App\Providers\GoogleStudentProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {     
        Paginator::useBootstrap();
        Schema::defaultStringLength(191);
        
       Socialite::extend('google_student', function ($app) {
            $config = $app['config']['services.google_student'];
            return new GoogleStudentProvider(
                $app['request'],
                $config['client_id'],
                $config['client_secret'],
                $config['redirect']
            );
        });
    }
}
