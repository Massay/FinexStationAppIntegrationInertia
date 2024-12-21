<?php

namespace App\Providers;

use App\Actions\FuelPump\FuelPumpApiConnector;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(FuelPumpApiConnector::class, function ($app) {
            return  new FuelPumpApiConnector("*****","***");
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Http::macro('fuelPumpApp', function () {
            return Http::withHeaders([
                'Accept' => 'application/json',
            ])->baseUrl('https://dev.fuelpumpgm.com');
            //dev.fuelpumpgm.com
        });
    }
}
