<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Carbon;
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
        // Varsayılan işlemler atayabiliyoruz
        Paginator::useBootstrapFive();
        Carbon::setLocale(config('app.locale'));
        // custom olarak kullanmakiçin default viev ile blade'i ekle
        // Paginator::defaultView("");
    }
}
