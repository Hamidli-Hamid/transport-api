<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Contracts\DistanceServiceInterface;
use App\Services\GoogleDistanceService;
use GuzzleHttp\Client;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton(DistanceServiceInterface::class, function ($app) {
            $apiKey = env('GOOGLE_MAPS_API_KEY');
            
            if (!$apiKey) {
                throw new \InvalidArgumentException('Google Maps API Key is not found.');
            }

            return new GoogleDistanceService(
                new Client(),
                $apiKey
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
