<?php

namespace App\Providers;

use App\Models\Company;
use App\Observers\CompanyVersionObserver;
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
        Company::observe(CompanyVersionObserver::class);
    }
}
