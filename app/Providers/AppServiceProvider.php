<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Stage;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share stages with all admin views
        View::composer('layouts.admin', function ($view) {
            $view->with('stages', Stage::all());
        });
    }
}
