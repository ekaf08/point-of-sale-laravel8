<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\setting;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $setting = Setting::first();

        view()->composer('layouts.master', function ($view) {
            $view->with('setting', Setting::first());
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
