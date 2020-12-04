<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        View::composer('costumer.*', 'App\Http\View\CategoryComposer');
        View::composer('layouts.layout', 'App\Http\View\CartComposer');
        View::composer('layouts.layout', 'App\Http\View\ProductComposer');
    }
}
