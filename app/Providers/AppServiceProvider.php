<?php

namespace App\Providers;

use App\Models\Service;
use App\Models\CaffeMenu;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {
            $view->with([
                'services' => Service::all(),
                'caffeMenus' => CaffeMenu::all(),
            ]);
        });
    }
}
