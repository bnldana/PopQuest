<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    public function boot()
    {
        View::composer('*', function ($view) {
            $routeName = \Route::currentRouteName();
            $bodyId = Str::slug($routeName, '-');
            $view->with('bodyId', $bodyId);
        });
    }
}
