<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ReservationService;


class ReservationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ReservationService::class, function ($app) {
            return new ReservationService();
        });
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
