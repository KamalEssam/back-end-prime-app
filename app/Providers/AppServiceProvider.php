<?php

namespace App\Providers;

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

        if (!isset($_SESSION)) {
            session_start();
        }

        if (!isset($_SESSION['applocale'])) {
            $_SESSION['applocale'] = 'en';
        } else {
            $_SESSION['applocale'] = 'en';
        }


        \Schema::defaultStringLength(191);

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
