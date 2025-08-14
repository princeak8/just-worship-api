<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\GivingPartner;
use App\Observers\GivingPartnerObserver;

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
        GivingPartner::observe(GivingPartnerObserver::class);
    }
}
