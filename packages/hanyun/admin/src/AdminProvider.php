<?php

namespace Hanyun\Admin;

use Illuminate\Support\ServiceProvider;

class AdminProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->loadRoutesFrom(__DIR__.'/routers/admin.php');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
